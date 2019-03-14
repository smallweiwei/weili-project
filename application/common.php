<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @param $code 错误/成功码
 * @param string $msg 错误/成功描述
 * @param string $count 统计
 * @param array $data 返回数据
 * @return string json返回
 */
function json($code,$msg = '',$count = '',$data = array()){
    $result=array(
        'code'=>$code,
        'msg'=>$msg,
        'count'=>$count,
        'data'=>$data
    );

    //输出json
    echo json_encode($result);
}


/**
 * 验证码配置加时间日期
 * @return string 返回月份和日期
 */
function yzm(){
    return date('m').date('d');
}

/**
 * 检测数组的值是否和传过来的值有相等的
 * @param $array  数组
 * @param string $keyName  数组下标
 * @param string $valName  传值
 * @return bool
 */
function array_in_repeat($array,$keyName='',$valName=''){
    foreach ($array as $key=>$val){
        if($val[$keyName] == $valName){
            return false;
        }
    }
    return true;
}

/**
 *  根据父id查询分类
 * @param $data 数组
 * @param $pId  父id
 * @return array|string
 */
function classify($data, $pId){
    $tree = array();
    foreach($data as $k => $v)
    {
        if($v['ar_pid'] == $pId)
        {        //父亲找到儿子
            $v['ar_pid'] = classify($data, $v['ar_id']);
            $tree[] = $v;
            // unset($data[$k]);
        }
    }
    return $tree;
}

/**
 * 获取数组中符合字符串的值
 * @param array $array  数组
 * @param string $array_key  数组下标
 * @param string $string  字符串
 * @param string $division 字符串分隔符
 * @return array  返回数组
 */
function array_accord_string($array=array(),$array_key='',$string='',$division=''){
    $data = array();
    if($division != ''){
        $strArray = explode($division,$string);//获取切割后字符串的数组
        foreach ($strArray as $key=>$value){
            foreach ($array as $k=>$v){
                if($v[$array_key] == $value){
                    $data[] = $v;
                }
            }
        }
        return $data;
    }else{
        foreach ($array as $key=>$value){
            if($value[$array_key] == $string){
                $data[] = $value;
            }
        }
        return $data;
    }
}


/**
 * 根据查询的值，和from表单提交的值判断是否有没有修改
 * @param $array 根据条件查询的数组
 * @param $data from提交的值
 * @return bool  返回true/false  true 无修改  false 有修改
 */
function array_check_data($array,$data){
    if(!is_judge_array($array)){
        $newArray = $array[0];
    }else{
        $newArray = $array;
    }
    $start = true;
    foreach ($data as $key=>$val){
        if($newArray[$key] != $val){
            $start = false;
        }
    }
    return $start;
}

/**
 * 判断数组是一维数组还是多维数组
 * @param $array 数组
 * @return bool true 一维 / false  多维
 */
function is_judge_array($array){
    if(count($array) == count($array,1)){
        return true;
    }else{
        return false;
    }
}

/**
 * 判断修改的数据中是否有改变
 * @param $oldArray  查询的数组
 * @param $dataArray 提交的数组
 * @param string $keyName 判断的数组下标
 * @return bool 返回true or false  true 有修改数据  false 无修改数据
 */
function is_modify_name($oldArray,$dataArray,$keyName=''){
    $data = true;
    if(!is_judge_array($oldArray)){
        $newArray = $oldArray[0];
    }else{
        $newArray = $oldArray;
    }
    foreach ($dataArray as $key=>$val){
        if($newArray[$keyName] == $val){
            return false;
        }
    }
    return $data;
}

/**
 * 根据key值删除数组，返回删除key后的数组
 * @param $array 数组
 * @param $key 键值
 * @return array 新数组（无传过来key的数组）
 */
function remove_array_key($array,$key){
    $data = array();
    foreach ($array as $k=>$v){
        if($k != $key){
            $data[$k] = $v;
        }
    }
    return $data;
}