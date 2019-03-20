<?php
/**
 * Created by PhpStorm.
 * Users: 蔡威威
 * Date: 2018/11/17
 * Time: 23:42
 */
namespace app\admin\behavior;
use traits\controller\Jump;
use think\facade\Session;
class UserCheck
{
    use Jump;//类里面引入jump类
    //绑定到CheckAuth标签，可以用于检测Session以用来判断用户是否登录
    public function run($params){
        $uid = Session::get('adminId');
        // 这里的session 是当用户登录成功后创建的一个session 如果没有的话就代表没有用户登录
        if(!isset($uid)){
            $uid = "";
        }

        if($uid == null || $uid == "" || $uid == "null" || $uid == 0){
            return $this->error('您还未登录，请先登录！','/login.html', 1,1);
        }
    }
}