<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/2/19
 * Time: 11:28
 */

namespace app\admin\controller;
/**
 * 系统设置控制器
 * Class system
 * @package app\admin\controller
 */
class System extends Basic
{
    /**
     * 系统设置页面
     * @return mixed
     */
    public function SystemView(){
        return $this->fetch();
    }
}