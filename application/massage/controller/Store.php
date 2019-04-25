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
use think\facade\Request;

class Store extends Controller
{
    /**
     * 获取推拿门店列表
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function storeList(){
        if(!Cache::get('store_list')){
            $list = Db::name('massage_store')->select();
            Cache::set('store_list',$list);
            return json('200','推拿门店获取成功',count($list),$list);
        }
        return json('200','推拿门店获取成功',count(Cache::get('store_list')),Cache::get('store_list'));
    }

    //显示推拿门店列表
    public function massageList(){
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

    private function storeTime($time,$array,$store,$today){
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

    //根据时间条件查询预约情况
    private function storeReser($time,$store){

        $list = Db::name('massage_reser')
            ->where('mr_time',$time)
            ->where('mr_state','1')
            ->where('mr_msid',$store)
            ->count();
        return $list;
    }

}