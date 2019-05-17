<?php


namespace app\admin\logic;
use app\admin\model\Manager;
use app\admin\model\MassagePersonnel;
use app\admin\model\StorePersonnel;


/**
 * 后台登录逻辑层
 * Class login
 * @package app\admin\login
 */
class Login
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
        $manager = new manager();
        $massagePersonnel = new MassagePersonnel();


        $list = $manager->find(array('m_name'=>$data['m_name']));

        if(empty($list)){
            $this->is_store_name($data['m_name']);
//            $mp = $massagePersonnel->find(array('mp_name|mp_spell'=>$data['m_name']));
//            if(empty($mp)){
//
//            }else{
//                return $mp;
//                exit;
//            }
        }else{
            return $list;
            exit;
        }
    }

    public function is_store_name($name){
        $storePersonnel = new StorePersonnel();
        $sp = $storePersonnel->find(array('sp_name|sp_spell'=>$name));
        if(empty($sp)){
            return json('-1003','管理员不存在');
            exit;
        }else{
            return $sp;
            exit;
        }
    }

}