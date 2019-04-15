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
        $list = Db::name('massage_store')->where($data)->find();
        $i = 0;
        $time = array("日","一","二","三","四","五","六");

        $work = explode(',',$list['ms_workShift']);
        $massage_time = Config::get('app.massage_time');
        $workShift = array();
        foreach ($work as $key=>$value){
            $workShift[$key] = $massage_time[$value];
        }

        while ($i <= $list['ms_slot'])
        {
            if($i == 0){
                $list['slot'][$i] = '今天';
                $list['time'][$i] = date("Y年m月d日",strtotime("+".$i." day")). "";
                $list['workShift'][$i] = $workShift;
            }elseif ($i == 1){
                $list['slot'][$i] = '明天';
                $list['time'][$i] = date("Y年m月d日",strtotime("+".$i." day")). "";

                $list['workShift'][$i] = $workShift;
            }elseif ($i == 2){
                $list['slot'][$i] = '后天';
                $list['time'][$i] = date("Y年m月d日",strtotime("+".$i." day")). "";

                $list['workShift'][$i] = $workShift;
            }else{
                $list['slot'][$i] = '星期'.$time[date("w",strtotime("+".$i." day"))];
                $list['time'][$i] = date("Y年m月d日",strtotime("+".$i." day")). "";
                $list['workShift'][$i] = $workShift;
            }
            $i ++;
        }
        $this->assign('data',$list);
        return $this->fetch();
    }


}