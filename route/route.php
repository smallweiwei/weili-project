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

//api路由
Route::domain('api.buymelots.com', function () {
    Route::rule('/', 'api/index/index');
    Route::rule('store_massage_list', 'api/StoreMassage/StoreMassageList','GET');//获取全部推拿门店列表
    Route::rule('store_massage_list_page', 'api/StoreMassage/StoreMassageListPage','POST');//分页获取推拿门店列表
    Route::rule('massage_personnel_list', 'api/StoreMassage/massagePersonnelList','GET');//获取全部推拿员工列表
    Route::rule('massage_personnel_list_page', 'api/StoreMassage/massagePersonnelListPage','POST');//分页获取推拿员工列表

    Route::rule('store_list', 'api/Store/StoreList','GET');//获取全部门店列表


});

return [

];