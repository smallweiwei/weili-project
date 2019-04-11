<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/19
 * Time: 10:29
 */

namespace app\massage\controller;

use think\facade\Cookie;

class Store extends Basic
{
    public function initialize()
    {
        if(!parent::initialize()){
            Header("Location: error.html");
            exit;
        }

        if(empty(Cookie::get('u_mobile'))){
            Header("Location: register.html");
        }
    }

    public function index(){
        return $this->fetch();
    }

    //显示推拿门店列表
    public function massageList(){
        return $this->fetch();
    }


}