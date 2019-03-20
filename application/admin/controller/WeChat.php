<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/2/19
 * Time: 12:03
 */

namespace app\admin\controller;
use think\facade\Request;
use think\Db;

/**
 * 微信管理控制器
 * Class weChat
 * @package app\admin\controller
 */
class WeChat extends Basic
{
    //显示微信基础设置页面
    public function weChatView()
    {
        return $this->fetch();
    }

    /**
     * 根据条件查询配置信息
     * @param $c_key  配置项名称
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function weChatFind($c_key)
    {
        $list = Db::name('config')->where('c_key',$c_key)->find();
        $list['c_value'] = json_decode($list['c_value'],true);
        if(empty($list)){
            return json('-200','数据获取失败','',$list);
        }else{
            return json('200','数据获取成功','',$list);
        }
    }

    public function weChatConfig($c_key)
    {
        $data = Request::instance()->post();
        $find = Db::name('config')->where('c_key',$c_key)->find();
        if(empty($find)){
            $array['c_key'] = $c_key;
            $array['c_value'] = json_encode($data);
            $list = Db::name('config')->insert($array);
        }else{
            $array['c_value'] = json_encode($data);
            $list = Db::name('config')->where('c_key',$c_key)->update($array);
        }
        if(!empty($list)){
            return json('200','设置修改成功','','');
        }else{
            return json('-2109','设置修改失败','','');
        }

    }
}