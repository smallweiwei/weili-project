<?php
//配置文件
return [
// 默认模块名
    'default_module'         => 'massage',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空模块名
    'empty_module'           => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法前缀
    'use_action_prefix'      => false,
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,
];