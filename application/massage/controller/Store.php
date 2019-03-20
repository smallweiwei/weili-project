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
        }
    }

    public function index(){
        return $this->fetch();
    }

    //显示推拿门店列表
    public function massageList(){
        dump(Cookie::get('u_nickname'));
        return $this->fetch();
    }


}