<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2018/12/13
 * Time: 17:03
 */

namespace app\admin\controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;

/**
 * 管理员管理控制器
 * Class Manager
 * @package app\admin\controller
 */
class Manager extends Basic
{
    protected $sort = 'ar_sort';
    protected $order = 'asc';
    protected $roleWhere = array('ag_delete'=>'1');

//管理员管理-管理员列表操作方法  start

    /**
     * 显示管理员列表页面
     * @return mixed
     */
    public function managerView()
    {
        return $this->fetch();
    }

    /**
     * 显示添加管理员页面
     * @return mixed
     */
    public function managerAddView()
    {
        return $this->fetch();
    }

    /**
     * 获取管理员列表
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function managerList()
    {
        $data = Request::instance()->post();
        $list = Db::name('manager')
            ->alias('m')
            ->join('auth_group_access aga','m.m_id = aga.uid')
            ->join('auth_group ag','ag.ag_id = aga.group_id')
            ->order($data['sort'],$data['order'])
            ->where('m.m_delete',1)
            ->field('m.m_id,m.m_name,m.m_sex,m.m_state,m.m_addTime,ag.ag_id,ag.ag_title')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-2100','管理员列表数据获取失败','','');
        }
    }

    /**
     * 修改管理员状态
     * @param $m_id 管理员id
     * @param $ag_id 角色id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function managerState($m_id,$ag_id)
    {
        $data = Request::instance()->post();
        if(empty($data)){
            return json('-2101','非法操作','','');
        }

        if($m_id == Session::get('adminSession.m_id')){
            return json('-2102','无法修改自己的状态','','');
        }

        if($m_id == '1'){
            return json('-2103','无权限操作此管理员,请联系开发人员操作');
        }

        if(Session::get('adminSession.ag_id') > $ag_id){
            return json('-2104','无权限修改','','');
        }
        $list = Db::name('manager')
            ->where('m_id',$m_id)
            ->data($data)
            ->update();
        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            if($data['m_state'] == '1'){
                return json('-2205','管理员启用失败','','');
            }else{
                return json('-2205','管理员停用失败','','');
            }
        }
    }

    /**
     * 添加管理员方法
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function managerAdd()
    {
        $data = Request::instance()->post();
        if($this->managerName(array('m_name'=>$data['m_name']))){
            $ag = $data['ag_id'];
            $array = remove_array_key($data,'ag_id');
            $array['m_password'] = $this->passworHash($array['m_password']);
            $uid = Db::name('manager')
                ->insertGetId($array);
            if(!empty($uid)){
                $aga['uid'] = $uid;
                $aga['group_id'] = $ag;
                $list = Db::name('auth_group_access')
                    ->insert($aga);
                if(!empty($list)){
                    return json('200','管理员添加成功','','');
                }else{
                    return json('-2107','管理员添加失败','','');
                }
            }else{
                return json('-2107','管理员添加失败','','');
            }
        }
    }

    /**
     * 根据条件查询管理员名称是否存在
     * @param $where 条件
     * @return bool|string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function managerName($where)
    {
        $list = Db::name('manager')
            ->where($where)
            ->select();
        if(!empty($list)){
            return json('-2106','管理员名称已存在','');
        }else{
            return true;
        }
    }

    /**
     * 显示修改管理员页面
     * @return mixed
     */
    public function managerSaveView()
    {
        return $this->fetch();
    }

    /**
     * 修改管理员信息
     * @param $m_id 管理员id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function managerSave($m_id)
    {
        $data = Request::instance()->post();
        if(isset($data['ag_id'])){
            //只修改角色
            if(empty(remove_array_key($data,'ag_id'))){
                $list = Db::name('auth_group_access')
                    ->where('uid = '.$m_id)->setField('group_id',$data['ag_id']);
            }else{
                Db::name('auth_group_access')
                    ->where('uid = '.$m_id)->setField('group_id',$data['ag_id']);
                $data = remove_array_key($data,'ag_id');
                $list = Db::name('manager')->where('m_id = '.$m_id)->update($data);
            }
        }else{
            $list = Db::name('manager')->where('m_id = '.$m_id)->update($data);
        }

        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            return json('-2108','管理员修改失败','','');
        }
    }

    /**
     * 根据条件删除管理员
     * @param $m_id 管理员id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function managerDel($m_id)
    {
        if($m_id == Session::get('adminSession.m_id')){
            return json('-2102','无法删除自己','','');
        }
        $data = Request::instance()->post();
        $list = Db::name('manager')->where('m_id = '.$m_id)->update($data);
        if(!empty($list)){
            return json('200','管理员伪删除成功','','');
        }else{
            return json('-2109','管理员伪删除失败','','');
        }
    }


//管理员管理-管理员列表操作方法  end


//管理员管理-角色列表操作方法  start

    /**
     * 显示角色列表页面
     * @return mixed
     */
    public function roleView()
    {
        return $this->fetch();
    }

    /**
     * 添加角色页面
     * @return mixed
     */
    public function roleAddView()
    {
        return $this->fetch();
    }

    /**
     * 获取角色列表
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function roleList()
    {
        $data = Request::instance()->get();
        $list = Db::name('auth_group')
            ->order($data['sort'],$data['order'])
            ->where($this->roleWhere)
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-2200','角色列表获取失败','','');
        }
    }

    /**
     * 修改角色状态
     * @param $ag_id  角色id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function roleState($ag_id)
    {
        $data = Request::instance()->post();
        if($ag_id == session('adminSession.ag_id')){
            return json('-2201','无法修改同组角色','','');
        }
        if(session('adminSession.ag_id') > $ag_id){
            return json('-2202','无权限修改角色','','');
        }
        $list = Db::name('auth_group')->where('ag_id = '.$ag_id)->update($data);
        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            return json('-2203','状态修改失败','','');
        }
    }

    /**
     * 添加角色
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function roleAdd(){
        $data = Request::instance()->post();
        if($this->roleTest(array('ag_title'=>$data['ag_title']))){
            $list = Db::name('auth_group')
                ->insert($data);
            if(!empty($list)){
                return json('200','修改成功','','');
            }else{
                return json('-2204','角色添加失败','','');
            }
        }
    }

    /**
     * 根据id修改角色信息
     * @param $ag_id 角色id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function roleSave($ag_id)
    {
        $data = Request::instance()->post();
        $roleFind = $this->roleWhereList(array('ag_id'=>$ag_id));
        if(!empty($roleFind[0]['ag_rules'])){
            if(!isset($data['ag_rules'])){
                $data['ag_rules'] = '';
            }
        }
        if(array_check_data($this->roleWhereList(array('ag_id'=>$ag_id)),$data)){
            return json('-2306','无修改信息,请修改角色信息','');
            exit;
        }
        if (is_modify_name($this->roleWhereList(array('ag_id'=>$ag_id)),$data,'ag_title')){
            if($this->roleTest(array('ag_title'=>$data['ag_title']))){
                $list = Db::name('auth_group')
                    ->where('ag_id='.$ag_id)
                    ->update($data);
            }
        }else{
            $list = Db::name('auth_group')
                ->where('ag_id='.$ag_id)
                ->update($data);
        }
        if(!empty($list)){
            return json('200','修改成功','','');
            exit;
        }else{
            return json('-2207','角色修改失败','','');
            exit;
        }
    }

    /**
     * 删除角色
     * @param $ag_id 角色id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function roleDel($ag_id)
    {
        if($ag_id == session('adminSession.ag_id')){
            return json('-2208','无法删除自己','','');
        }
        if(session('adminSession.ag_id') > $ag_id){
            return json('-2209','无权限删除角色','','');
        }
        if($ag_id == '1' or $ag_id == '2'){
            return json('-2209','无法删除角色,请联系开发人员删除','','');
        }

        $agc = Db::name('auth_group_access')
            ->where('group_id = '.$ag_id)
            ->select();
        if(!empty($agc)){
            return json('-2211','角色下存在管理员，请彻底删除管理员后重试','','');
        }
        $list = Db::name('auth_group')
            ->where('ag_id='.$ag_id)
            ->delete();
        if(!empty($list)){
            return json('200','角色删除成功','','');
        }else{
            return json('-2210','角色删除失败','','');
        }
    }

    /**
     * 判断角色名称是否存在
     * @param $where  判断条件
     * @return bool|\think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function roleTest($where){
        $list = Db::name('auth_group')
            ->where($where)
            ->select();
        if(!empty($list)){
            return json('-2205','角色名已存在，请修改后重新提交','');
            exit;
        }else{
            return true;
        }
    }

    /**
     * 根据条件查询角色信息
     * @param $where 条件
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function roleWhereList($where)
    {
        return Db::name('auth_group')
            ->where($where)
            ->select();
    }

    public function apiRole(){
        $list =  Db::name('auth_group')
            ->select();
        if(empty($list)){
            return json('-2212','获取角色列表接口错误','');
        }else{
            return json('200','获取成功','',$list);
        }
    }

//管理员管理-角色列表操作方法  end


//管理员管理-权限列表操作方法  start
    /**
     * 显示权限列表页面
     * @return mixed
     */
    public function authView()
    {
        return $this->fetch();
    }

    /**
     * 获取权限列表
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function authList()
    {
        $data = Request::instance()->get();
        if(array_key_exists('ar_id',$data)){
            $list = Db::name('auth_rule')
                ->order($this->sort,$this->order)
                ->select();
            if(!empty($list)){
                return classify($list,0);
            }else{
                return json('-2300','权限列表获取失败','','');
            }
        }else{
            $list = Db::name('auth_rule')
                ->order($data['sort'],$data['order'])
                ->select();
            if(!empty($list)){
                return json('200','数据获取成功','',classify($list,0));
            }else{
                return json('-2300','权限列表获取失败','','');
            }
        }
    }

    /**
     * 根据权限id修改权限状态
     * @param $ar_id  权限表id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function authState($ar_id)
    {
        $data = Request::instance()->post();
        $list = Db::name('auth_rule')
            ->where('ar_id = '.$ar_id)
            ->update($data);
        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            return json('-2301','权限状态修改失败','','');
        }
    }

    /**
     * 权限排序
     * @param $ar_id 权限id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function authSort($ar_id)
    {
        $data = Request::instance()->post();
        $list = Db::name('auth_rule')
            ->where('ar_id = '.$ar_id)
            ->update($data);
        if(!empty($list)){
            return json('200','修改成功','',$this->authList());
        }else{
            return json('-2302','权限排序失败','','');
        }
    }

    /**
     * 显示添加权限页面
     */
    public function authAddView()
    {
        return $this->fetch();
    }

    /**
     * 添加权限
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function authAdd()
    {
        $data = Request::instance()->post();
        if($this->authTest($data['ar_pid'],$data['ar_name'],$data['ar_title'])){
            if($data['ar_sort'] == ''&& $data['ar_sort'] == 0){
                $data['ar_sort'] = 1;
            }
            $list = Db::name('auth_rule')
                ->insert($data);
            if(!empty($list)){
                return json('200','添加成功','','');
            }else{
                return json('-2305','权限添加失败','','');
            }
        }
    }

    /**
     * 修改权限信息
     * @param $ar_id  权限id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function authSave($ar_id)
    {
        $data = Request::instance()->post();
        $find = $this->authWhereList(array('ar_pid'=>$data['ar_pid']));

        if(array_check_data($this->authWhereList(array('ar_id'=>$ar_id)),$data)){
            return json('-2306','无修改信息,请修改权限信息','');
            exit;
        }
        if(is_modify_name($this->authWhereList(array('ar_id'=>$ar_id)),$data,'ar_title')){
            if(!array_in_repeat($find,'ar_title',$data['ar_title'])){
                return json('-2303','权限中文名称已存在,请重新输入','');
                exit;
            }
        }
        if(is_modify_name($this->authWhereList(array('ar_id'=>$ar_id)),$data,'ar_name')){
            if(!array_in_repeat($find,'ar_name',$data['ar_name'])){
                return json('-2304','权限英文名称已存在,请重新输入','');
                exit;
            }
        }
        if(is_modify_name($this->authWhereList(array('ar_id'=>$ar_id)),$data,'ar_pid')){
            if($this->authTest($data['ar_pid'],$data['ar_name'],$data['ar_title'])){
                $list = Db::name('auth_rule')
                    ->where('ar_id='.$ar_id)
                    ->update($data);
                if(!empty($list)){
                    return json('200','修改成功','','');
                    exit;
                }else{
                    return json('-2307','权限修改失败','','');
                    exit;
                }
            }
        }
        $list = Db::name('auth_rule')
            ->where('ar_id='.$ar_id)
            ->update($data);

        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            return json('-2307','权限修改失败','','');
        }
    }

    /**
     * 权限删除 判断删除权限下存不存在子类
     * @param $ar_id 权限id
     * @return \think\response\Json|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function authDel($ar_id)
    {
        if(empty($this->authWhereList(array('ar_pid'=>$ar_id)))){
            $list = Db::name('auth_rule')
                ->where('ar_id='.$ar_id)
                ->delete();
            if(!empty($list)){
                return json('200','删除成功','','');
            }else{
                return json('-2309','权限删除失败','','');
            }
        }else{
            return json('-2308','权限下存在子类，请删除后再重新删除','');
            exit;
        }
    }

    /**
     * 检查权限中文/英文名称是否存在
     * @param $ar_pid 父权限/子权限
     * @param $ar_name 权限英文名称
     * @param $ar_title  权限中文名称
     * @return \think\response\Json|void 不存在返回true 存在返回错误信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function authTest($ar_pid,$ar_name,$ar_title)
    {
        $list = $this->authWhereList(array('ar_pid'=>$ar_pid));
        if(!array_in_repeat($list,'ar_title',$ar_title)){
            return json('-2303','权限中文名称已存在,请重新输入','');
            exit;
        }
        if(!array_in_repeat($list,'ar_name',$ar_name)){
            return json('-2304','权限英文名称已存在,请重新输入','');
            exit;
        }
        return true;
    }

    /**
     * 根据条件查询权限列表
     * @param $where  各种条件
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function authWhereList($where)
    {
        return Db::name('auth_rule')
            ->where($where)
            ->select();
    }

//管理员管理-权限列表操作方法  end

}