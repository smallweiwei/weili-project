<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/20
 * Time: 12:03
 */

namespace app\massage\controller;

/**
 * 微信客户端打开
 */
use think\Controller;

class Wrong extends Controller
{
    public function index(){
        $this->view->config('view_path', 'template/massage/');
        return $this->fetch();
    }
}