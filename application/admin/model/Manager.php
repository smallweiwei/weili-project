<?php


namespace app\admin\model;
use think\Model;

/**
 * 后台管理员模型层 [处理数据库 查看,修改,删除,添加等操作]
 * Class manager 管理员表后缀 [全称  wl_manager ]
 * @package app\admin\model
 */
class Manager extends Model
{
    protected $pk = 'm_id'; //数据库主键

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    public function find($where)
    {
        dump($this->where($where)->find());
    }
}