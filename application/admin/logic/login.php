<?php


namespace app\admin\logic;
use app\admin\model\manager;
use think\Db;


/**
 * 后台登录逻辑层
 * Class login
 * @package app\admin\login
 */
class login
{
    /**
     * 判断传过来的值是否为空
     * @param $data  表单提交的值
     * @return bool|string|\think\response\Json  返回json或者true
     */
    public function is_null($data)
    {
        if(empty($data['m_name']) || empty($data['m_password'])){
            return json('-1002','用户名密码不能为空');
            exit;
        }else{
            return $this->is_name($data);
        }
    }

    //判断是否管理员名称是否存在
    public function is_name($data)
    {
        $where['m_name'] = $data['m_name'];
        $list = Db::name('manager')->where($where)->find();
        if(!empty($list)){

        }
    }
}