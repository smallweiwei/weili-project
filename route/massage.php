<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/18
 * Time: 15:05
 */
//Route::domain('massage.buymelots.com', function () {
Route::domain('wx.94vessel.cn', function () {
    Route::rule('', 'massage/Index/index');
    Route::rule('index', 'massage/Index/index');
    Route::rule('weixinApi', 'massage/weixin/weixinApi');
    Route::rule('massage','massage/Store/massageList');
    Route::rule('GetOpenid','massage/Store/GetOpenid');
    Route::rule('error','massage/Wrong/index');
    Route::rule('register','massage/Wrong/register');
    Route::rule('verifyName','massage/Wrong/verify');
    Route::rule('registerApi','massage/Wrong/registerApi');
    Route::rule('user','massage/User/userList');
});