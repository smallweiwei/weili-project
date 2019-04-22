<?php
namespace app\massage\controller;
use think\facade\Cookie;

class Index extends Basic
{
    public function initialize()
    {
//        dump(Cookie::get('u_mobile'));
        if(!parent::initialize()){
            Header("Location: error.html");
            exit;
        }
        if(empty(Cookie::get('u_mobile'))){
            Header("Location: register.html");
        }
    }

    public function index()
    {
        return $this->fetch();
    }
}
