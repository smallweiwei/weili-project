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
     * @return string|Json
     */
    public function storeAdd(){
        $data = Request::instance()->post();
        $store = new storeLogic();
        $list = $store->storeAdd($data);
//        $list = Db::name('store')
//            ->insert($data);
        if(!empty($list)){
            return json('200','添加成功','','');
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
     * @return string|Json
     * @throws Exception
     * @throws PDOException
     */
    public function storeSave($s_id)
    {
        $where['s_id'] = $s_id;
        $data = Request::instance()->post();
        $list = Db::name('store')
            ->where($where)
            ->update($data);
        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            return json('-5102','门店信息修改失败','','');
        }
    }

    public function storeDel($s_id)
    {
        $store = new storeLogic();
        $list = $store->storeFind($s_id);
        dump($list);
    }
}