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

class User extends Controller
{
    public function userList()
    {
        $data = json_decode(Cookie::get('u_user_id'),true);
        $this->assign('data',$data);
        return $this->fetch();
    }

    //获取列表
    public function reserList(){
        $data = Request::instance()->get();
        if($data['time'] == 0){
            $list = Db::name('massage_reser')
                ->where('mr_uid',$data['u_user_id'])
                ->where('mr_state','1')
                ->whereTime('mr_time','>=',time())
                ->select();
        }else{
            $list = Db::name('massage_reser')
                ->where('mr_uid',$data['u_user_id'])
                ->where('mr_state','1')
                ->whereTime('mr_time','<',time())
                ->select();
        }

        if(!empty($list)){
            return json('200','列表获取成功',count($list),$list);
        }else{
            return json('-200','预约列表获取失败');
        }
    }
}