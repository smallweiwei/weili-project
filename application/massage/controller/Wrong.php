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
use think\facade\Cookie;
use think\facade\Request;
use think\Db;

class Wrong extends Controller
{
    public function initialize()
    {
        if(!empty(Cookie::get('u_mobile'))){
            Header("Location: index.html");
        }
    }

    /**
     * 显示错误页面
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 判断有没有手机号码绑定
     * @return mixed
     */
    public function register(){
        if(!strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
            Header("Location: error.html");
            exit;
        }
        return $this->fetch();
    }

    //验证电话是否存在
    public function verify(){
        $data = Request::instance()->post();
        $list = Db::name('users')
                ->where('u_mobile',$data['phone'])
                ->find();
        if(!empty($list)){
            return json('error','手机号码存在');
            exit;
        }else{
            return json('success','手机号码不存在');
            exit;
        }
    }

    /**
     * 绑定用户手机号码和密码
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function registerApi(){
        $request = Request::instance()->post();
        Cookie::set('u_mobile',$request['phone']);//把手机号码存在cookie中
        $data['u_mobile'] = $request['phone'];
        $data['u_password'] = $this->passworHash($request['password']);
        $list = Db::name('users')->where('u_user_id',Cookie::get('u_user_id'))->update($data);//返回新增id
        if(!empty($list)){
            return json('200','绑定成功','',$list);
            exit;
        }else{
            return json('-200','绑定失败');
            exit;
        }
    }

    /**
     * 密码 hash加密
     * @param string $password 密码
     * @return bool|string 返回字符串
     */
    public static function passworHash($password = '123456')
    {
        return password_hash($password,PASSWORD_DEFAULT,['cost'=>10]);
    }
}