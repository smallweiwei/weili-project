<?php
namespace app\api\controller;
use think\Db;
use think\facade\Request;
class Store
{
    public function StoreList()
    {
        $list = Db::name('store')
            ->field('s_id,s_name,s_phone,s_address,s_pic,s_time,s_delete')
            ->where('s_delete','1')
            ->select();
        if(!empty($list)){
            return json('200','数据获取成功','',$list);
        }else{
            return json('-5100','门店获取失败','','');
        }
    }

    /**
     * 分页显示门店员工列表
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function storeStaffListPage()
    {
        $data = Request::instance()->post();
        $where = [];
        if($data['sp_sId'] != 0){
            $where['sp.sp_sId'] = $data['sp_sId'];
        }
        if(isset($data['search'])) {
            $where[] = ['sp_name|sp_spell|s_name
            ', 'LIKE', "%" . $data['search'] . "%"];
        }
        $where['sp_delete'] = '1';

        $count =  Db::name('store_personnel')
            ->alias('sp')
            ->join('store s','sp.sp_sId  = s.s_id')
            ->order($data['sort'],$data['order'])
            ->where($where)
            ->field('sp.sp_name,sp.sp_spell,sp.sp_state,sp_time,sp.sp_id,s.s_name,s.s_id')
            ->count();
        $list =  Db::name('store_personnel')
            ->alias('sp')
            ->join('store s','sp.sp_sId  = s.s_id')
            ->order($data['sort'],$data['order'])
            ->where($where)
            ->field('sp.sp_name,sp.sp_spell,sp.sp_state,sp_time,sp.sp_id,s.s_name,s.s_id')
            ->select();
        return !empty($list) ? json('200', '数据获取成功', $count, $list) : json('-5200', '门店员工获取失败', '', '');

    }
}