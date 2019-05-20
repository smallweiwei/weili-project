<?php


namespace app\admin\logic;
use app\admin\model\Manager;
use app\admin\model\MassagePersonnel;
use app\admin\model\StorePersonnel;
use PDOStatement;
use think\facade\Config;
use think\Model;
use think\response\Json;
use think\Db;


/**
 * 后台登录逻辑层
 * Class login
 * @package app\admin\login
 */
class Login
{
    private $massage_personnel_name = '门店小儿推拿';
    private $store_name = '乐婴岛门店';

    /**
     * 判断传过来的值是否为空
     * @param $data  表单提交的值
     * @return bool|string|Json  返回json或者true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login_logic($data)
    {
        if(empty($data['m_name']) || empty($data['m_password'])){
            return json('-1002','用户名密码不能为空');
            exit;
        }else{
            return $this->is_name($data);
            exit;
        }
    }


    /**
     * 判断是否是管理员表
     * @param $data 前台登录页面输入的值
     * @return array|mixed|PDOStatement|string|Model|Json|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function is_name($data)
    {
        $manager = new manager();
        //Model查询出数据  第一个参数是查询条件,第二个参数是查询的字段,空的话查询全部字段
        $list = $manager->find(
            array('m_name'=>$data['m_name'],'m_delete'=>'1'),
            ['m_id','m_name','m_password','m_sex','m_state']
        );
        if(empty($list)){
            return $this->is_massage_personnel_name($data);//管理员表查询不到数据就查询推拿员工表
            exit;
        }else{
            if($list['m_state'] != '1'){
                return json('-1004','禁止登录');
                exit;
            }

            if(password_verify($data['m_password'],$list['m_password']) === false){
                return json('-1005','账号或者密码不正确');
                exit;
            }
            $where['uid'] = $list['m_id'];
            $auth_group = Db::name('auth_group_access')->where($where)->find();
            $list = Db::table(Config::get('database.prefix').'manager')
                ->alias('m')
                ->join(Config::get('database.prefix').'auth_group_access aga','aga.uid = m.m_id')
                ->join(Config::get('database.prefix').'auth_group ag','aga.group_id = ag.ag_id')
                ->where('ag_id = '.$auth_group['group_id'].' and m.m_id='.$list['m_id'])
                ->field('m.m_id,m.m_name,m.m_password,m.m_state,m_delete,ag.ag_id,ag.ag_title,ag.ag_status,ag.ag_rules,ag.ag_delete')
                ->find();
            return $list;
        }
    }

    /**
     * 判断是否是推拿门店员工,输入密码是否正确
     * @param $data 前台登录页面输入的值
     * @return array|mixed|PDOStatement|string|Model|Json|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function is_massage_personnel_name($data)
    {
        $massage_personnel = new MassagePersonnel();
        //Model查询出数据  第一个参数是查询条件,第二个参数是查询的字段,空的话查询全部字段
        $list = $massage_personnel->find(
            array('mp_name|mp_spell'=>$data['m_name'],'mp_delete'=>'1'),
            ['mp_id','mp_msId','mp_name','mp_password','mp_spell','mp_state','mp_delete']
        );
        $massage = $this->massage_personnel_role();
        if(empty($list)){
            return $this->is_store_name($data);//门店推拿员工表v没有查询到结果从门店员工表查询
            exit;
        }else{
            if($list['mp_state'] != '1'){
                return json('-1004','禁止登录');
                exit;
            }
            if(password_verify($data['m_password'],$list['mp_password']) === false){
                return json('-1005','账号或者密码不正确');
                exit;
            }
            $array['m_name'] = $list['mp_name'];
            $array['ag_title'] = $massage['ag_title'];
            $array['ag_rules'] = $massage['ag_rules'];
            return $array;
        }
    }

    /**
     * 判断门店员工是否存在,密码是否正确
     * @param $data 前台登录页面输入的值
     * @return array|mixed|PDOStatement|string|Model|Json|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function is_store_name($data)
    {
        $store_personnel = new StorePersonnel();
        //Model查询出数据  第一个参数是查询条件,第二个参数是查询的字段,空的话查询全部字段
        $list = $store_personnel->find(
            array('sp_name|sp_spell'=>$data['m_name'],'sp_delete'=>'1'),
            ['sp_id','sp_sId','sp_name','sp_password','sp_spell','sp_state','sp_delete']
        );
        $store = $this->store_personnel_role();
        if(empty($list)){
            return json('-1003','管理员不存在');
            exit;
        }else{
            if($list['sp_state'] != '1'){
                return json('-1004','禁止登录');
                exit;
            }
            if(password_verify($data['m_password'],$list['sp_password']) === false){
                return json('-1005','账号或者密码不正确');
                exit;
            }
            $array['m_name'] = $list['sp_name'];
            $array['ag_title'] = $store['ag_title'];
            $array['ag_rules'] = $store['ag_rules'];
            return $array;
        }
    }

    /**
     * 查询角色信息
     * @return array|null|PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function massage_personnel_role(){
        $list = Db::name('auth_group')
            ->where('ag_title',$this->massage_personnel_name)
            ->field('ag_title,ag_rules')
            ->find();
        return $list;
    }

    /**
     * 查询角色信息
     * @return array|null|PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function store_personnel_role(){
        $list = Db::name('auth_group')
            ->where('ag_title',$this->store_name)
            ->field('ag_title,ag_rules')
            ->find();
        return $list;
    }
}