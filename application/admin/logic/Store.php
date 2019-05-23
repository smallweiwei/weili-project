<?php


namespace app\admin\logic;
use app\admin\model\Store as storeModel;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\response\Json;

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
//        $list = $storeModel->save([
//            's_name'  =>  $array['s_name'],
//            's_address' =>  $array['s_address'],
//            's_phone' =>  $array['s_phone'],
//            's_pic' =>  $array['s_pic'],
//        ]);
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
        if($list){
            return json('200','门店删除成功','','');
            exit;
        }else{
            return json('-5104','门店删除失败','','');
            exit;
        }

    }

    //获取门店员工列表
    public function storeStaffList($array = []){
        dump($array);
    }

}