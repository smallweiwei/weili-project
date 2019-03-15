<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//header('Access-Control-Allow-Origin','*');
Route::domain('www.buymelots.com', function () {
    Route::rule('/', 'home/index/index');
});

Route::domain('massage.buymelots.com', function () {
    Route::rule('/', 'massage/index/index');
});

//api路由
Route::domain('api.buymelots.com', function () {
    Route::rule('/', 'api/index/index');
    Route::rule('login', 'api/login/login');//登录页面路由
    Route::rule('manager', 'api/manager/managerList');
    Route::rule('managerState','api/manager/managerState','GET|POST');
});

return [

];