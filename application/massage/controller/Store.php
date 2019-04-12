<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/19
 * Time: 10:29
 */

namespace app\massage\controller;

use think\facade\Cache;
use think\Controller;
use think\Db;

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

//    public function initialize()
//    {
//        if(!parent::initialize()){
//            Header("Location: error.html");
//            exit;
//        }
//
//        if(empty(Cookie::get('u_mobile'))){
//            Header("Location: register.html");
//        }
//    }
//
//    public function index(){
//        return $this->fetch();
//    }
//
    //显示推拿门店列表
    public function massageList(){
        return $this->fetch();
    }


}