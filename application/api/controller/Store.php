<?php


namespace app\api\controller;


use think\Db;

class Store
{
    public function StoreList()
    {
        $list = Db::name('store')
            ->field('s_id,s_name,s_phone,s_address,s_pic,s_time,s_delete')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-5100','门店获取失败','','');
        }
    }
}