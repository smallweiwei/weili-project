<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/3/19
 * Time: 10:29
 */

namespace app\massage\controller;
use EasyWeChat\Factory;
use think\Db;

class Store extends Basic
{
    public function initialize()
    {
        parent::initialize();
    }

    //显示推拿门店列表
    public function massageList(){
        return $this->fetch();
    }


}