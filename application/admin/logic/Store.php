<?php


namespace app\admin\logic;
use app\admin\model\Store as storeModel;

class Store
{
    public function storeFind($s_id){
        $list = storeModel::get($s_id);
        dump($list['s_pic']);
    }

    public function storeAdd($array = [])
    {
        $store = storeModel::where('s_name',$array['s_name'])->find();
        if(!empty($store)){
            return json('-5103','门店名称已存在,请重新输入','','');
            exit;
        }
    }
}