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
function json($code,$msg = '',$count = '',$data = array())
{
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
function yzm()
{
    return date('m').date('d');
}

/**
 * 检测数组的值是否和传过来的值有相等的
 * @param $array  数组
 * @param string $keyName  数组下标
 * @param string $valName  传值
 * @return bool
 */
function array_in_repeat($array,$keyName='',$valName='')
{
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
function classify($data, $pId)
{
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
function array_accord_string($array=array(),$array_key='',$string='',$division='')
{
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
function array_check_data($array,$data)
{
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
function is_judge_array($array)
{
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
function is_modify_name($oldArray,$dataArray,$keyName='')
{
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
function remove_array_key($array,$key)
{
    $data = array();
    foreach ($array as $k=>$v){
        if($k != $key){
            $data[$k] = $v;
        }
    }
    return $data;
}

/**
 * 拼接签名字符串
 * @param $urlObj  数组
 * @return string 返回拼接的字符串
 */
function ToUrlParams($urlObj)
{
    $buff = "";
    foreach ($urlObj as $k => $v)
    {
        if($k != "sign"){
            $buff .= $k . "=" . $v . "&";
        }
    }

    $buff = trim($buff, "&");
    return $buff;
}

/**
 * CURL请求
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug  调试开启 默认false
 * @return mixed
 */
function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $method = strtoupper($method);
    $ci = curl_init();
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 30); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if($ssl){
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
}