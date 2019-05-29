<?php


namespace app\admin\logic;
use app\admin\model\Store as storeModel;
use app\admin\model\StorePersonnel as spModel;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\response\Json;
use think\Db;

/**
 * 门店逻辑类
 * Class Store
 * @package app\admin\logic
 */
class Store
{

    /**
     * 添加门店逻辑方法
     * @param array $array
     * @return string|Json
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function storeAdd($array = [])
    {
        $storeModel = new storeModel;
        $store = storeModel::where('s_name',$array['s_name'])->find();
        if(!empty($store)){
            return json('-5102','门店名称已存在,请重新输入','','');
            exit;
        }
        $storeModel->s_name = $array['s_name'];
        $storeModel->s_address = $array['s_address'];
        $storeModel->s_phone = $array['s_phone'];
        $storeModel->s_pic = $array['s_pic'];
        $list = $storeModel->save();
        if($list){
            return json('200','门店添加成功','',$storeModel->s_id);
            exit;
        }else{
            return json('-5101','门店添加失败','','');
            exit;
        }
    }

    /**
     * 更新门店信息
     * @param $s_id 门店id
     * @param array $array 传过来的数组
     * @return string|Json
     * @throws Exception
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws PDOException
     */
    public function storeSave($s_id,$array = [])
    {
        $storeModel = new storeModel();
        $find = storeModel::where('s_name',$array['s_name'])->find();
        if(!empty($find)){
            return json('-5102','门店名称已存在,请重新输入','','');
            exit;
        }
        $list = $storeModel->where('s_id',$s_id)
            ->update([
            's_name'  =>  $array['s_name'],
            's_address' =>  $array['s_address'],
            's_phone' =>  $array['s_phone'],
            's_pic' =>  $array['s_pic'],
        ]);
        if($list){
            return json('200','门店修改成功','',$storeModel->s_id);
            exit;
        }else{
            return json('-5103','门店修改失败','','');
            exit;
        }
    }

    /**
     * 删除门店信息(伪删除)
     * @param $s_id 门店id
     * @return string|Json
     */
    public function storeDel($s_id)
    {
        $store = storeModel::get($s_id);
        $store->s_delete = '-1';
        $list = $store->save();
        return !empty($list) ? json('200', '门店删除成功','', '') : json('-5104', '门店删除失败', '', '');
    }

    //判断是否有修改门店员工信息

    /**
     *  判断是否有修改信息，无修改返回提示，有修改则更新门店员工表
     * @param $sp_id 门店员工id
     * @param array $data 修改数据
     * @return string|Json
     * @throws DataNotFoundException
     * @throws DbException
     * @throws Exception
     * @throws ModelNotFoundException
     * @throws PDOException
     */
    public function isModifyStoreStaff($sp_id,$data = [])
    {
        if(array_check_data($this->StoreStaffFind(array('sp_id'=>$sp_id)),$data)){
            return json('-5202','无修改信息,请修改推拿员工信息','');
            exit;
        }
        $list = Db::name('store_personnel')
            ->where('sp_id='.$sp_id)
            ->update($data);
        return !empty($list) ? json('200', '修改成功','', $list) : json('-5203', '门店员工信息修改失败', '', '');
    }

    /**
     * 根据条件查询员工信息
     * @param array $where
     * @return array|\PDOStatement|string|\think\Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function StoreStaffFind($where = [])
    {
        return spModel::where($where)->select();
    }

    /**
     * 删除门店员工（伪删除）
     * @param array $where
     * @param array $save
     * @return string|Json
     * @throws Exception
     * @throws PDOException
     */
    public function storeStaffSave($where = [], $save = [])
    {
        $storeStaff = spModel::get($where);
        $storeStaff->sp_delete = '-1';
        $list = $storeStaff->save();
        return !empty($list) ? json('200', '门店员工删除成功','', '') : json('-5204', '门店员工删除失败', '', '');
    }
    /**
     * 根据条件删除门店员工
     * @param array $where
     * @return string|Json
     * @throws Exception
     * @throws PDOException
     */
    public function storeStaffDel($where = [])
    {
        $list = spModel::where($where)->delete();
        return !empty($list) ? json('200', '门店员工删除成功','', '') : json('-5204', '门店员工删除失败', '', '');
    }
}