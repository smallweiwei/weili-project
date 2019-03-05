<?php
namespace app\api\controller;

use think\Controller;
use think\facade\Session;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch('404.html');
    }



}
