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
    protected $field = ['sp_id','sp_sId','sp_name','sp_password','sp_spell','sp_state','sp_delete','sp_time']; //表字段

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