<?php


namespace app\api\controller;


use think\Db;
use think\facade\Request;

class StoreMassage
{
    //获取推拿门店
    public function StoreMassageList()
    {
        $list = Db::name('massage_store')
            ->field('ms_id,ms_name,ms_phone,ms_address,ms_workShift,ms_pic,ms_time,ms_number')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-9000','推拿门店获取失败','','');
        }
    }

    public function massagePersonnelListPage(){
        $data = Request::instance()->post();
        dump($data);
    }
}