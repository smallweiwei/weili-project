<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/3/1
 * Time: 17:24
 */

namespace app\admin\controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
/**
 * 门店推拿管理
 * Class StoreMassage
 * @package app\admin\controller
 */
class StoreMassage extends Basic
{
    /**
     * 显示推拿门店 门店列表
     * @return mixed
     */
    public function StoreMassageListView(){
        return $this->fetch();
    }

    /**
     * 获取推拿门店列表
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function StoreMassageList(){
        $data = Request::instance()->post();
        $list = Db::name('store_massage')
            ->order($data['sort'],$data['order'])
            ->field('sm_id,sm_name,sm_phone,sm_address,sm_pic,sm_time')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-9000','推拿门店获取失败','','');
        }
    }

    /**
     * 显示推拿门店添加门店页面
     * @return mixed
     */
    public function StoreMassageAddView(){
        return $this->fetch();
    }

}