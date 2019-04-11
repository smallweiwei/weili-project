<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
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
     * 显示推拿门店修改页面
     * @return mixed
     */
    public function StoreMassageSaveView(){
        return $this->fetch();
    }

    /**
     * 修改推拿门店信息
     * @param $ms_id 推拿门店id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function StoreMassageSave($ms_id){
        $where['ms_id'] = $ms_id;
        $data = Request::instance()->post();
        $list = Db::name('massage_store')
            ->where($where)
            ->update($data);
        if(!empty($list)){
            return json('200','添加成功','','');
        }else{
            return json('-9003','推拿门店修改失败','','');
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
            return json('-9000','推拿门店获取失败','','');
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

    /**
     * 修改推拿员工信息
     * @param $mp_id  员工信息
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function staffSave($mp_id){
        $data = Request::instance()->post();
        if(array_check_data($this->staffFind(array('mp_id'=>$mp_id)),$data)){
            return json('-9102','无修改信息,请修改推拿员工信息','');
            exit;
        }
        $list = Db::name('massage_personnel')
            ->where('mp_id='.$mp_id)
            ->update($data);
        if(!empty($list)){
            return json('200','修改成功','','');
        }else{
            return json('-9103','推拿员工信息修改失败','','');
        }
    }

    /**
     * 删除推拿员工信息
     * @param $mp_id 推拿员工id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function staffDel($mp_id){
        $list = Db::name('massage_personnel')
            ->where('mp_id='.$mp_id)
            ->delete();
        if(!empty($list)){
            return json('200','推拿员工删除成功','','');
        }else{
            return json('-9104','推拿员工删除失败','','');
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
    private function staffFind($where){
        return Db::name('massage_personnel')
            ->where($where)
            ->select();
    }

    /**
     * 获取推拿门店和员工
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function massageStoreList(){
        $data = array();
        $massage_store = Db::name('massage_store')
            ->field('ms_id,ms_name')
            ->select();
        foreach ($massage_store as $key=>$value){
            $massage_personnel = Db::name('massage_personnel')
                ->where('mp_msId',$value['ms_id'])
                ->field('mp_id,mp_name')
                ->select();
            $data[$key]['store'] = $massage_personnel;
            $data[$key]['ms_name'] = $value['ms_name'];
        }
        return !empty($data) ? json('200', '数据获取成功', '', $data) : json('-9100', '推拿门店员工获取失败', '', '');
    }

//推拿门店  员工列表  end

//推拿门店  排班设置 start

    /**
     * 显示推拿门店排班设置
     * @return mixed
     */
    public function schedulingView(){
        return $this->fetch();
    }

    /**
     * 获取推拿门店排班设置
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function schedulingList(){
        $data = Request::instance()->post();
        $list = Db::name('massage_rest')
            ->alias('mr')
            ->join('massage_personnel mp','mr.mr_mpId = mp.mp_id')
            ->where('mr.mr_date','>=',$data['start'])
            ->where('mr.mr_date','<',$data['end'])
            ->field('mp.mp_name,mr.mr_date,mr.mr_id,mr.mr_mpId')
            ->select();
        if(!empty($list)){
            return json('200','排班数据获取成功','',$list);
        }else{
            return json('-9200','排班设置获取失败','','');
        }
    }

    /**
     * 添加推拿门店排班设置
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function schedulingAdd(){
        $data = Request::instance()->post();
        $find = Db::name('massage_rest')
            ->where($data)
            ->find();
        if(!empty($find)){
            return json('-9204','数据重复，请刷新后重试','','');
            exit;
        }
        $list = Db::name('massage_rest')
            ->insert($data);
        if(!empty($list)){
            return json('200','添加成功','',$list);
        }else{
            return json('-9201','排班设置添加失败,请刷新后重新拉取','','');
        }
    }

    /**
     * 修改推拿员工休息时间
     * @param $id  推拿员工休息表id
     * @param $date 修改前的时间
     * @param $mp_id  推拿员工id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function schedulingSave($id,$date,$mp_id){
        //一,修改前判断修改后的时间有没有用户预约服务
        $data = Request::instance()->post();
        $find = Db::name('massage_rest')
            ->where($data)
            ->where('mr_mpId',$mp_id)
            ->find();
        if(!empty($find)){
            return json('-9205','修改的日期已存在,请重新选择日期','','');
            exit;
        }

        $list = Db::name('massage_rest')
            ->where('mr_id',$id)
            ->update($data);

        if(!empty($list)){
            return json('200','排班修改成功','',$list);
        }else{
            return json('-9206','排班修改失败','','');
        }
    }

    /**
     * 删除排班休息时间
     * @param $mr_id 排班休息时间表id
     * @return string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function schedulingDel($mr_id){
        $list = Db::name('massage_rest')
            ->where('mr_id',$mr_id)
            ->delete();
        if(!empty($list)){
            return json('200','删除成功','',$list);
        }else{
            return json('-9203','排班设置删除失败','','');
        }
    }

//推拿门店  排班设置 end

}