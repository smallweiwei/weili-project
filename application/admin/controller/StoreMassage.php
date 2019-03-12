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
use \Yurun\Util\Chinese;
use \Yurun\Util\Chinese\Pinyin;

/**
 * 门店推拿管理
 * Class StoreMassage
 * @package app\admin\controller
 */
class StoreMassage extends Basic
{

//推拿门店   门店列表  start

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
        $list = Db::name('massage_store')
            ->order($data['sort'],$data['order'])
            ->field('ms_id,ms_name,ms_phone,ms_address,ms_workShift,ms_pic,ms_time')
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

    /**
     * 添加推拿门店方法
     * @return string|\think\response\Json
     */
    public function StoreMassageAdd(){
        $data = Request::instance()->post();
        $list = Db::name('massage_store')
            ->insert($data);
        if(!empty($list)){
            return json('200','添加成功','','');
        }else{
            return json('-9001','添加推拿门店方法','','');
        }
    }

    /**
     * 删除推拿门店信息
     * @param $ms_id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function StoreMassageDel($ms_id){

        $array = $this->findStoreMassage(array('ms_id'=>$ms_id));
        if(!empty($array['ms_pic'])){
            unlink($array['ms_pic']);
        }
        $list = Db::name('massage_store')->where('ms_id = '.$ms_id)->delete();
        if(!empty($list)){
            return json('200','推拿门店删除成功','','');
        }else{
            return json('-9002','推拿门店删除失败','','');
        }
    }

    /**
     * 获取推拿门店单信息
     * @param array $array 条件
     * @return array|null|\PDOStatement|string|\think\Model|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function findStoreMassage($array = array()){
        $list = Db::name('massage_store')->where($array)->find();
        if(!empty($list)){
            return $list;
        }else{
            return json('-9003','推拿门店获取失败','','');
        }
    }

    /**
     * 获取全部推拿门店列表
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function MassageStore(){
        $list = Db::name('massage_store')->select();
        if(!empty($list)){
            return json('200','推拿门店获取成功',count($list),$list);
        }else{
            return json('-9000','推拿门店获取失败','','');
        }
    }

//推拿门店   门店列表  end

//推拿门店  员工列表  start

    /**
     * 显示推拿门店 员工列表页面
     * @return mixed
     */
    public function staffListView(){
        return $this->fetch();
    }

    /**
     * 获取推拿门店员工列表
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function staffList(){
        $data = Request::instance()->post();
        $list = Db::name('massage_personnel')
            ->alias('mp')
            ->join('massage_store ms','mp.mp_msId = ms.ms_id')
            ->order($data['sort'],$data['order'])
            ->field('mp.mp_id,mp.mp_name,mp.mp_workShift,mp.mp_time,mp.mp_spell,ms.ms_name,ms.ms_id')
            ->select();
        return !empty($list) ? json('200', '数据获取成功', '', $list) : json('-9100', '推拿门店员工获取失败', '', '');
    }

    /**
     * 显示添加推拿门店员工列表
     * @return mixed
     */
    public function staffAddView(){
        return $this->fetch();
    }

    /**
     * 添加推拿员工方法
     * @return string|\think\response\Json
     */
    public function staffAdd(){
        $data = Request::instance()->post();
        if($data['mp_password'] === ''){
            $data['mp_password'] = $this->passworHash('123456qwerty');
        }else{
            $data['mp_password'] = $this->passworHash($data['mp_password']);
        }
        $list = Db::name('massage_personnel')
            ->insert($data);
        if(!empty($list)){
            return json('200','添加成功','','');
        }else{
            return json('-9101','推拿员工添加失败','','');
        }
    }

    public function staffSave($mp_id){
        $data = Request::instance()->post();
        if(array_check_data($this->staffFind(array('mp_id'=>$mp_id)),$data)){
            return json('-9102','无修改信息,请修改推拿员工信息','');
            exit;
        }


    }

    /**
     * 根据条件查询推拿员工
     * @param $where
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function staffFind($where){
        return Db::name('massage_personnel')
            ->where($where)
            ->select();
    }

//推拿门店  员工列表  end

}