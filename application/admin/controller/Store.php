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
use think\facade\Request;
/**
 * 门店管理控制器
 * Class store
 * @package app\admin\controller
 */
class Store extends Basic
{
    protected $order = 'asc';

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
            ->field('s_id,s_name,s_phone,s_address,s_pic,s_time')
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

    /**
     * 添加门店信息 方法
     * @return string|\think\response\Json
     */
    public function storeAdd(){
        $data = Request::instance()->post();
        $list = Db::name('store')
            ->insert($data);
        if(!empty($list)){
            return json('200','添加成功','','');
        }else{
            return json('-5100','门店添加失败','','');
        }
    }
}