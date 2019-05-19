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
    protected $field = ['mp_id','mp_msId','mp_name','mp_password','mp_spell','mp_workShift','mp_state','mp_delete','mp_time']; //表字段

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