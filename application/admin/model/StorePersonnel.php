<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/5/17
 * Time: 10:28
 */

namespace app\admin\model;
use think\Model;

class StorePersonnel extends Model
{
    protected $pk = 'sp_id'; //数据库主键

    public function find($where)
    {
        return $this->where($where)->find();
    }
}