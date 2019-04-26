<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/19
 * Time: 10:29
 */

namespace app\massage\controller;

use think\App;
use think\facade\Cache;
use think\Controller;
use think\Db;
use think\facade\Config;
use think\facade\Cookie;
use think\facade\Request;

class Store extends Controller
{
    public $weixin_config;
    public function initialize()
    {
        $wechat = Db::name('config')
            ->where('c_key','weChat')
            ->value('c_value');
        $config = json_decode($wechat,true);
        $this->weixin_config = $config;
    }
    /**
     * 获取推拿门店列表
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function storeList()
    {
        if(!Cache::get('store_list')){
            $list = Db::name('massage_store')->select();
            Cache::set('store_list',$list);
            return json('200','推拿门店获取成功',count($list),$list);
        }
        return json('200','推拿门店获取成功',count(Cache::get('store_list')),Cache::get('store_list'));
    }

    /**
     * 显示推拿门店列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function massageList()
    {
        $data = Request::instance()->get();
        $list = Db::name('massage_store')
            ->where($data)
            ->field('ms_id,ms_name,ms_phone,ms_address,ms_slot,ms_number,ms_workShift,ms_pic')
            ->find();
        $i = 0;
        $time = array("日","一","二","三","四","五","六");
        $work = explode(',',$list['ms_workShift']);
        $massage_time = Config::get('app.massage_time');
        $workShift = array();
        foreach ($work as $key=>$value){
            $workShift[$key] = $massage_time[$value];
        }

        while ($i < $list['ms_slot'])
        {
            if($i == 0){
                $list['workShift'][$i] = $this->storeTime(date("Y-m-d",strtotime("+".$i." day")),$workShift,$list,1);
                $list['title'][$i]['key'] = '今天';
                $list['title'][$i]['value'] = date("Y年m月d日",strtotime("+".$i." day")). "";
            }elseif ($i == 1){
                $list['workShift'][$i] = $this->storeTime(date("Y-m-d",strtotime("+".$i." day")),$workShift,$list,2);
                $list['title'][$i]['key'] = '明天';
                $list['title'][$i]['value'] = date("Y年m月d日",strtotime("+".$i." day")). "";
            }elseif ($i == 2){
                $list['workShift'][$i] = $this->storeTime(date("Y-m-d",strtotime("+".$i." day")),$workShift,$list,2);
                $list['title'][$i]['key'] = '后天';
                $list['title'][$i]['value'] = date("Y年m月d日",strtotime("+".$i." day")). "";
            }else{
                $list['workShift'][$i] = $this->storeTime(date("Y-m-d",strtotime("+".$i." day")),$workShift,$list,2);
                $list['title'][$i]['key'] =  '星期'.$time[date("w",strtotime("+".$i." day"))];
                $list['title'][$i]['value'] = date("Y年m月d日",strtotime("+".$i." day")). "";
            }
            $i ++;
        }
        
        $this->assign('data',$list);
        return $this->fetch();
    }

    /**
     * 添加预约信息
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function reser_from()
    {
        $data = Request::instance()->post();
        $user = json_decode(Cookie::get('u_user_id'),true);
        $time = $this->reserTime($data);
        $array['mr_uid'] = $user['u_user_id'];
        $array['mr_msid'] = $data['mr_msid'];
        $array['mr_name'] = $data['mr_name'];
        $array['mr_time'] = $time;
        $array['mr_phone'] = $data['mr_phone'];
        $array['mr_remarks'] = $data['mr_remarks'];
        $array['mr_state'] = '1';
        $this->successNotice();
        exit;
        if(!$this->reserFull($data['mr_msid'],$time)){
            return json('-200','预约失败，请刷新后重选时间');
            exit;
        }else{
            $list = Db::name('massage_reser')->insertGetId($array);
            if(!empty($list)){
                return json('200','预约成功','',$list);
            }else{
                return json('-200','预约失败，请刷新后重选时间','','');
            }
        }
    }

    /**
     * 获取有没有人休息，时间段是否约满等
     * @param $time 传的时间，今天到可预约结束时间
     * @param $array 时间段
     * @param $store 门店信息
     * @param $today 是否是今天 1为今天 2为以后
     * @return array 返回数组
     */
    private function storeTime($time,$array,$store,$today)
    {
        $count = Db::name('massage_rest')
            ->alias('mr')
            ->join('massage_personnel mp','mr.mr_mpId = mp.mp_id')
            ->where('mr.mr_date',$time)
            ->where('mp.mp_msId',$store['ms_id'])
            ->field('mr.mr_id,mr.mr_date,mr.mr_mpId,mp.mp_msId')
            ->count();
        $data = array();
        if($today == 1){
            foreach ($array as $key=>$value){
                if(time() >= strtotime($time.' '.$value)){
                    $data[$key]['expire'] = 'false';
                }else{
                    $data[$key]['expire'] = 'true';
                }
            }
        }else{
            foreach ($array as $key=>$value){
                $data[$key]['expire'] = 'true';
            }
        }
        //没有人休息
        if(empty($count)){
            foreach ($array as $key=>$value){
                $num = $this->storeReser(strtotime($time.' '.$value),$store['ms_id']);
                //区分金沙店特殊
                if($store['ms_id'] == 1){

                    if($value >= '14:00'){
                        $data[$key]['time'] = $value;
                        $n = $store['ms_number']-$num;
                        if($n == 0){
                            $data[$key]['state'] = 'false';
                        }else{
                            $data[$key]['state'] = 'true';
                        }
                        $data[$key]['value'] = ($store['ms_number']-$num);
                    }else{
                        $n = ($store['ms_number']-1-$num);
                        if($n == 0){
                            $data[$key]['state'] = 'false';
                        }else{
                            $data[$key]['state'] = 'true';
                        }
                        $data[$key]['time'] = $value;
                        $data[$key]['value'] = ($store['ms_number']-1-$num);
                    }
                }else{
                    $n = ($store['ms_number']-$num);
                    if($n == 0){
                        $data[$key]['state'] = 'false';
                    }else{
                        $data[$key]['state'] = 'true';
                    }
                    $data[$key]['time'] = $value;
                    $data[$key]['value'] = ($store['ms_number']-$num);
                }
            }
        }else{
            foreach ($array as $key=>$value){
                $num = $this->storeReser(strtotime($time.' '.$value),$store['ms_id']);
                //区分金沙店特殊
                if($store['ms_id'] == 1){
                    if($value >= '14:00'){
                        $n = ($store['ms_number']-$count-$num);
                        if($n == 0){
                            $data[$key]['state'] = 'false';
                        }else{
                            $data[$key]['state'] = 'true';
                        }
                        $data[$key]['time'] = $value;
                        $data[$key]['value'] = ($store['ms_number']-$count-$num);
                    }else{
                        $n = ($store['ms_number']-$count-1-$num);
                        if($n == 0){
                            $data[$key]['state'] = 'false';
                        }else{
                            $data[$key]['state'] = 'true';
                        }
                        $data[$key]['time'] = $value;
                        $data[$key]['value'] = ($store['ms_number']-$count-1-$num);
                    }
                }else{
                    $n = ($store['ms_number']-$count-$num);
                    if($n == 0){
                        $data[$key]['state'] = 'false';
                    }else{
                        $data[$key]['state'] = 'true';
                    }
                    $data[$key]['time'] = $value;
                    $data[$key]['value'] = ($store['ms_number']-$count-$num);
                }
            }
        }
        return $data;
    }

    /**
     * 根据时间查询预约情况
     * @param $time 预约时间
     * @param $store 门店id
     * @return float|string
     */
    private function storeReser($time,$store)
    {
        $list = Db::name('massage_reser')
            ->where('mr_time',$time)
            ->where('mr_state','1')
            ->where('mr_msid',$store)
            ->count();
        return $list;
    }

    /**
     *  获取预约的时间戳
     * @param $array 传过来的值
     * @return false|int 返回的时间戳
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function reserTime($array)
    {
        $list = Db::name('massage_store')
            ->where('ms_id',$array['mr_msid'])
            ->field('ms_id,ms_name,ms_phone,ms_address,ms_slot,ms_number,ms_workShift,ms_pic')
            ->find();
        $work = explode(',',$list['ms_workShift']);
        $massage_time = Config::get('app.massage_time');
        $workShift = array();
        foreach ($work as $key=>$value){
            $workShift[$key] = $massage_time[$value];
        }
        $time = strtotime(date("Y-m-d",strtotime("+".$array['date']." day")).' '.$workShift[$array['reser_time']]);
        return $time;
    }

    //判断时间段是否约满
    private function reserFull($store,$time)
    {

        //查询推拿门店信息
        $list = Db::name('massage_store')
            ->where('ms_id',$store)
            ->field('ms_id,ms_name,ms_phone,ms_address,ms_slot,ms_number,ms_workShift,ms_pic')
            ->find();

        //查询上班人数
        $n = Db::name('massage_rest')
            ->alias('mr')
            ->join('massage_personnel mp','mr.mr_mpId = mp.mp_id')
            ->where('mr.mr_date',date('Y-m-d',$time))
            ->where('mp.mp_msId',$store)
            ->field('mr.mr_id,mr.mr_date,mr.mr_mpId,mp.mp_msId')
            ->count();

        $num = $list['ms_number'] - $n;//上班人数
        //查询预约情况
        $reser = Db::name('massage_reser')
            ->where('mr_time',$time)
            ->where('mr_state','1')
            ->select();
        if(($num - count($reser)) > 0){
            return true;
        }else{
            return false;
        }
    }

    //发送模板消息
    public function successNotice()
    {
        $user = json_decode(Cookie::get('u_user_id'),true);
        $wx = $this->weixin_config;
        $token = getWxAccessToken($wx['wc_appid'],$wx['wc_appsecret']);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token['access_token'];
        $array = array(
            'touser' => $user['u_openid'],
            'template_id' =>'3-fbZIC-Lm_ZTXKFR5gbRtHDvpylfgN3HFJTysl1mEQ',
            'url' => 'https://m.buymelots.com/index.php?s=/Reser/User/index',
            'data' => array(
                'first' => array(
                    'value'=>'您好,您的预约已经成功,请准时赴约',
                    'color' =>'#173177',
                ),
                'keyword1' =>array(
                    'value'=>'测试',
                    'color' =>"#173177",
                ),
                'keyword2' =>array(
                    'value'=>'测试',
                    'color' =>"#173177",
                ),
                'keyword3' =>array(
                    'value'=>'门店',
                    'color' =>"#173177",
                ),
                'keyword4' =>array(
                    'value'=>'时间',
                    'color'=>'#173177',
                ),
                'keyword5' =>array(
                    'value'=>'小儿推拿',
                    'color'=>'#173177',
                ),
                'remark' =>array(
                    'value'=>'备注：联系电话',
                    'color' =>"#173177",
                )
            ),
        );
        $data = json_encode($array);
        http_curl($url,'post',$data);
    }
}