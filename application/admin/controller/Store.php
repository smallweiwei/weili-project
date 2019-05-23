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

    public function storeStaffList(){
        $data = Request::instance()->post();
        $store = new storeLogic();
        $store->storeStaffList($data);
    }
//员工列表功能 end

}