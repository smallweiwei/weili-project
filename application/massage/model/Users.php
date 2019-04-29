<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/4/11
 * Time: 11:44
 */

namespace app\massage\model;
use think\Model;

class Users extends Model
{
    public function thirdLogin($data){
        $where['u_openid'] = $data['u_openid'];
        $user = $this->findUser($where);
        if(!$user){
            $user = Users::save($data);
        }
        return $user;
    }

    public function findUser($where){
        return Users::where($where)->find();
    }
}