<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/5/16
 * Time: 16:38
 */

namespace app\admin\model;
use think\Model;

class MassagePersonnel extends Model
{
    protected $pk = 'mp_id'; //数据库主键

    public function find($where)
    {
        return $this->where($where)->find();
    }
}