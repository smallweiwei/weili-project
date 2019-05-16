<?php
/**
 * Created by PhpStorm.
 * Users: 蔡威威
 * Date: 2018/11/18
 * Time: 0:02
 */
namespace app\admin\controller;
use app\admin\logic\Login as logic_login;
use think\Controller;
use think\facade\Config;
use think\Db;
use think\facade\Request;
use think\facade\Session;
/**
 * 后端登录界面
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
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        $data = Request::instance()->post();
        $name = Request::instance()->param('m_name');
        $password = Request::instance()->param('m_password');
//        $yzm = Request::instance()->param('idCode');
//        //判断验证码是否正确
//        if($yzm != (Config::get('yzm').yzm())){
//            return json('-1000','验证码不正确');
//            exit;
//        }

        //判断是否通过表单提交
        if(!request()->isPost()){
            return json('-1001','非法登录');
        }
        $massage = new logic_login();
        $massage->is_null($data);
//        $name = $massage->is_name($data);
//        dump($name);/
        exit;


        $array['m_name'] = $data['m_name'];
        $m_id = Db::name('manager')->where($array)->field('m_id')->find();
        if(empty($m_id)){
            return json('-1003','管理员不存在');
            exit;
        }
        $list = $this->managerInfo($m_id['m_id']);

        if(empty($list)){
            return json('-1003','管理员不存在');
            exit;
        }
        if($list['m_state'] != '1'){
            return json('-1004','禁止登录');
            exit;

        }
        if($list['m_delete'] != '1'){
            return json('-1004','账号不存在');
            exit;
        }
        if(password_verify($data['m_password'],$list['m_password']) === false){
            return json('-1006','账号或者密码不正确');
            exit;
        }

        Session::set('adminSession',$list);

        if(!empty($list)){
            return json('200','登录成功','1',$list);
        }else{
            return json('-200','登录失败');
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
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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
            Session::set('adminSession','');//清除缓存
            return $this->error('退出成功！','/login.html', 1,1);
        }else{
            return $this->error('非法操作！','/', 1,1);
        }
    }

}