<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/4/11
 * Time: 17:42
 */

namespace app\massage\controller;


class User extends Basic
{
    public function userList(){
        return $this->fetch();
    }
}