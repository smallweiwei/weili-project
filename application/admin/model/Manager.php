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
    protected $field = ['m_id','m_name','m_password','m_sex','m_addTime','m_state','m_delete']; //表字段

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    //查询单条数据
    public function find($where,$array = [])
    {
        if(empty($array)){
            $field = $this->field;
        }else{
            $field = $array;
        }
        return $this->where($where)->field($field)->find();
    }
}