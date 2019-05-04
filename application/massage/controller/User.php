<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/4/11
 * Time: 17:42
 */

namespace app\massage\controller;


use think\Controller;
use think\facade\Cookie;
use think\facade\Request;
use think\Db;
use think\facade\Session;

class User extends Controller
{
    public function userList()
    {
        $data = json_decode(Cookie::get('u_user_id'),true);
        $data['u_user_id'] = '1';
        $newReserList = Db::name('massage_reser')
                ->alias('mr')
                ->join('massage_store ms','mr.mr_msid = ms.ms_id')
                ->where('mr.mr_uid',$data['u_user_id'])
                ->where('mr.mr_state','1')
                ->whereTime('mr.mr_time','>=',time())
                ->field('mr.mr_id,mr.mr_uid,mr.mr_msid,mr.mr_time,ms.ms_name')
                ->select();
        foreach ($newReserList as $key=>$val){
            $newReserList[$key]['startTime'] = date('Y年m月d日 H:i',$val['mr_time']);
            $newReserList[$key]['endTime'] = date('Y年m月d日 H:i',($val['mr_time']+60*30));
        }

        $ReserList = Db::name('massage_reser')
            ->alias('mr')
            ->join('massage_store ms','mr.mr_msid = ms.ms_id')
            ->where('mr.mr_uid',$data['u_user_id'])
            ->where('mr.mr_state','1')
            ->whereTime('mr.mr_time','<',time())
            ->order('mr.mr_time','desc')
            ->field('mr.mr_id,mr.mr_uid,mr.mr_msid,mr.mr_time,ms.ms_name')
            ->select();
        foreach ($ReserList as $key=>$val){
            $ReserList[$key]['startTime'] = date('Y年m月d日 H:i',$val['mr_time']);
            $ReserList[$key]['endTime'] = date('Y年m月d日 H:i',($val['mr_time']+60*30));
        }

//        dump($newReserList);
//        dump($ReserList);
        $this->assign('data',$data);
        $this->assign('newReserList',$newReserList);
        $this->assign('ReserList',$ReserList);
        return $this->fetch();
    }

    //获取列表
    public function reserList(){
//        dump(Session::get('u_user_id'));
//        $data = Request::instance()->get();
//        if($data['time'] == 0){
//            $list = Db::name('massage_reser')
//                ->alias('mr')
//                ->join('massage_store ms','mr.mr_msid = ms.ms_id')
//                ->where('mr.mr_uid',$data['u_user_id'])
//                ->where('mr.mr_state','1')
//                ->whereTime('mr.mr_time','>=',time())
//                ->field('mr.mr_id,mr.mr_uid,mr.mr_msid,mr.mr_time,ms.ms_name')
//                ->select();
//        }else{
//            $list = Db::name('massage_reser')
//                ->where('mr_uid',$data['u_user_id'])
//                ->where('mr_state','1')
//                ->whereTime('mr_time','<',time())
//                ->field('mr_id,mr_uid,mr_msid,mr_time')
//                ->select();
//        }

        if(!empty($list)){
            return json('200','列表获取成功',count($list),$list);
        }else{
            return json('-200','预约列表获取失败');
        }
    }
}