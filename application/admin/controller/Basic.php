<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2018/11/28
 * Time: 11:42
 */

namespace app\admin\controller;
use think\App;
use think\Controller;
use think\facade\Session;
use think\Db;
use think\facade\Request;

class Basic extends Controller
{
    public function initialize(){
        //判断有无adminId这个sessnion，如果没有，跳转到登陆界面
        if(!Session::get('adminSession')){
            return $this->error('您还未登录，请先登录！','/login.html', 1,1);
        }
    }

    /**
     * 获取菜单
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function menu(){
        $list = Db::name('auth_rule')
            ->where('ar_status = 1')
            ->order('ar_sort','asc')
            ->select();
        if(!empty($list)){
            return json('200','菜单获取成功','',classify(array_accord_string($list,'ar_id',Session::get('adminSession.ag_rules'),','),0));
            exit;
        }else{
            return json('-200','菜单获取失败','','');
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
     * 获取管理员信息
     * @return mixed
     */
    public function adminId()
    {
        $data['m_id'] = Session::get('adminSession.m_id');
        $data['m_password'] = Session::get('adminSession.m_password');
        return $data;
    }

    //上传图片页面
    public function uploadView(){
        return $this->fetch('public/upload_view');
    }

    //执行上传图片
    public function upload(){
        $data_get = Request::instance()->get();
        $file = request() -> file('file');

        $info = $file -> validate(['size' => 512000,'ext' => 'jpg,png,jpeg','type' => 'image/jpeg,image/png']) -> move('./static/uploads/'.$data_get['name']);
        if($info){
            $mes = $info->getSaveName();         // 文件扩展名
            $ajaxJson['success'] = true;
            $ajaxJson['mes'] = './static/uploads/'.$data_get['name'].'/'.$mes;
        }else{
            $mes = $file->getError();
            $ajaxJson['success'] = false;
            $ajaxJson['mes'] = $mes;
        }
        return json_encode($ajaxJson);
    }


}