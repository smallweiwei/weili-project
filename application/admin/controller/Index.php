<?php
namespace app\admin\controller;

class Index extends Basic
{
    public function index()
    {
        return $this->fetch();
    }

    public function Welcome(){
        return $this->fetch();
    }

}
