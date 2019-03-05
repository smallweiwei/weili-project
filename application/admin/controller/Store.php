<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/2/20
 * Time: 11:54
 */

namespace app\admin\controller;
use think\facade\Request;
use think\Db;
/**
 * 门店管理控制器
 * Class Store
 * @package app\admin\controller
 */
class Store extends Basic
{
    /**
     * 显示门店列表页面
     * @return mixed
     */
    public function storeListView()
    {
        return $this->fetch();
    }

    //获取门店列表信息
    public function storeList()
    {
        $data = Request::instance()->post();
        $list = Db::name('store')
            ->order($data['sort'],$data['order'])
            ->field('s_id,s_name,s_phone,s_address,s_addTime')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-9100','门店列表数据获取失败','','');
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

    public function storeAdd(){
//        $data = Request::instance()->post();
        $file = Request::file('s_pic');
        dump($file->getInfo());
        exit;
//        dump($data);
    }
}