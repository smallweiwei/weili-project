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

    /**
     * 获取门店列表信息
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
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
            return json('-5101','门店添加失败','','');
        }
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
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function storeSave($s_id)
    {
        $where['ms_id'] = $s_id;
        $data = Request::instance()->post();
        $list = Db::name('store')
            ->where($where)
            ->update($data);
        if(!empty($list)){
            return json('200','添加成功','','');
        }else{
            return json('-5102','门店信息修改失败','','');
        }
    }
}