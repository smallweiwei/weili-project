<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/2/20
 * Time: 11:54
 */

namespace app\admin\controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\facade\Request;
use app\admin\logic\Store as storeLogic;
use think\response\Json;

/**
 * 门店管理控制器
 * Class store
 * @package app\admin\controller
 */
class Store extends Basic
{
    protected $order = 'asc';

//门店列表功能 start
    /**
     * 显示门店列表页面
     * @return mixed
     */
    public function storeListView()
    {
        return $this->fetch();
    }

    /**
     * 获取门店列表信息
     * @return string|Json
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function storeList()
    {
        $data = Request::instance()->post();
        $list = Db::name('store')
            ->order($data['sort'],$data['order'])
            ->field('s_id,s_name,s_phone,s_address,s_pic,s_time')
            ->where('s_delete','1')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-5100','门店列表数据获取失败','','');
        }
    }

    /**
     * 显示添加门店页面
     * @return mixed
     */
    public function storeAddView()
    {
        return $this->fetch();
    }

    /**
     * * 添加门店信息 方法
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function storeAdd(){
        $data = Request::instance()->post();
        $store = new storeLogic();
        $store->storeAdd($data);
    }

    /**
     * 显示修改门店信息页面
     * @return mixed
     */
    public function storeSaveView()
    {
        return $this->fetch();
    }

    /**
     * 修改门店信息
     * @param $s_id  门店id
     * @return string|Json
     * @throws Exception
     * @throws PDOException
     */
    public function storeSave($s_id)
    {
        $data = Request::instance()->post();
        $store = new storeLogic();
        $store->storeSave($s_id,$data);
    }

    /**
     * 删除门店信息 (伪删除)
     * @param $s_id 要删除的门店id
     */
    public function storeDel($s_id)
    {
        $store = new storeLogic();
        $store->storeDel($s_id);
    }

//门店列表功能 end

//员工列表功能 start

    /**
     * 显示门店员工列表
     * @return mixed
     */
    public function storeStaffListView()
    {
        return $this->fetch();
    }

    /**
     * 获取门店员工列表
     * @return string|Json
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function storeStaffList()
    {
        $data = Request::instance()->post();
        $where = [];
        if($data['sp_sId'] != 0){
            $where['sp.sp_sId'] = $data['sp_sId'];
        }
        if(isset($data['search'])) {
            $where[] = ['sp_name|sp_spell|s_name
            ', 'LIKE', "%" . $data['search'] . "%"];
        }
        $where['sp_delete'] = '1';

        $count =  Db::name('store_personnel')
            ->alias('sp')
            ->join('store s','sp.sp_sId  = s.s_id')
            ->order($data['sort'],$data['order'])
            ->where($where)
            ->field('sp.sp_name,sp.sp_spell,sp.sp_state,sp_time,sp.sp_id,s.s_name,s.s_id')
            ->count();
        $list =  Db::name('store_personnel')
            ->alias('sp')
            ->join('store s','sp.sp_sId  = s.s_id')
            ->order($data['sort'],$data['order'])
            ->where($where)
            ->field('sp.sp_name,sp.sp_spell,sp.sp_state,sp_time,sp.sp_id,s.s_name,s.s_id')
            ->select();
        return !empty($list) ? json('200', '数据获取成功', $count, $list) : json('-5200', '门店员工获取失败', '', '');

    }

    /**
     * 显示添加门店员工页面
     * @return mixed
     */
    public function storeStaffAddView()
    {
        return $this->fetch();
    }

    /**
     * 添加门店员工方法
     * @return string|Json
     */
    public function storeStaffAdd()
    {
        $data = Request::instance()->post();
        if($data['sp_password'] === ''){
            $data['sp_password'] = parent::passworHash('123456qwerty');
        }else{
            $data['sp_password'] = parent::passworHash($data['sp_password']);
        }

        $list = Db::name('store_personnel')
            ->insertGetId($data);
        if(!empty($list)){
            Db::name('store_personnel_access')
                ->insert(array('sp_id'=>$list,'group_id'=>'3'));
            return json('200','添加成功','','');
        }else{
            return json('-9101','员工添加失败','','');
        }
    }

    /**
     * 修改门店员工页面
     * @return mixed
     */
    public function storeStaffSaveView()
    {
        return $this->fetch();
    }

    //修改门店员工信息
    public function storeStaffSave($sp_id)
    {
        $data = Request::instance()->post();
        $store = new storeLogic();
        return $store->isModifyStoreStaff($sp_id,$data);
    }

    public function storeStaffDel($sp_id)
    {
        $store = new storeLogic();
        return $store->storeStaffSave($sp_id,array('sp_delete'=>'2'));
    }

//员工列表功能 end

}