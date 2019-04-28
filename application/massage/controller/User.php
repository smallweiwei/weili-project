<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/4/11
 * Time: 17:42
 */

namespace app\massage\controller;


use think\Controller;
use think\facade\Cookie;

class User extends Controller
{
    public function userList()
    {
        $data = json_decode(Cookie::get('u_user_id'),true);
        $this->assign('data',$data);
        return $this->fetch();
    }
}