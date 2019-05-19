<?php
/**
 * Created by PhpStorm.
 * Users: 蔡威威
 * Date: 2018/11/18
 * Time: 0:02
 */
namespace app\admin\controller;
use app\admin\logic\Login as logic_login;
use PDOStatement;
use think\Controller;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\facade\Config;
use think\Db;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;
use think\Model;
use think\response\Json;

/**
 * 微粒管理后台登录界面
 * Class login
 * @package app\admin\controller
 */
class Login extends Controller
{
    /**
     * 判断有没有session，有就跳转到首页不进登录页面，没有就显示登录页面
     * @return mixed
     */
    public function index()
    {
        if(Session::get('adminSession')){
            header("location:/");
        }else{
            return $this->fetch();
        }
    }

    /**
     * 登录操作
     * $_post 前端传过来的值为用户名和密码
     * @return string|Json
     */
    public function login()
    {
        $data = Request::instance()->post();

        //判断是否通过表单提交
        if(!request()->isPost()){
            return json('-1001','非法登录');
        }

        $massage = new logic_login();
        $list = $massage->login_logic($data);//处理和判断前端传过来的值,返回false 或者 管理员信息
        dump($list);
        exit;
        if(!empty($list)){
            Session::set('adminSession',json_encode($list));
            Cookie::set('admin',json_encode($list));
            return json('200','登录成功','1',$list);
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


    /**
     * 根据角色管理员表管理查询角色
     * @param string $m_id  管理员id
     * @return array|null|PDOStatement|string|Model
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function managerInfo($m_id = '')
    {
        $where['uid'] = $m_id;
        $auth_group = Db::name('auth_group_access')->where($where)->find();
        $list = Db::table(Config::get('database.prefix').'manager')
            ->alias('m')
            ->join(Config::get('database.prefix').'auth_group_access aga','aga.uid = m.m_id')
            ->join(Config::get('database.prefix').'auth_group ag','aga.group_id = ag.ag_id')
            ->where('ag_id = '.$auth_group['group_id'].' and m.m_id='.$m_id)
            ->field('m.m_id,m.m_name,m.m_password,m.m_state,m_delete,ag.ag_id,ag.ag_title,ag.ag_status,ag.ag_rules,ag.ag_delete')
            ->find();
        return $list;
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        if(!empty(Session::get('adminSession'))){
            Session::delete('adminSession');//清除缓存
            return $this->error('退出成功！','/login.html', 1,1);
        }else{
            return $this->error('非法操作！','/', 1,1);
        }
    }

}