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
    Route::rule('weixinApi', 'massage/Weixin/weixinApi');
    Route::rule('store','massage/Store/massageList');
//    Route::rule('GetOpenid','massage/Store/GetOpenid');
    Route::rule('error','massage/Wrong/index');
    Route::rule('register','massage/Wrong/register');
    Route::rule('verifyName','massage/Wrong/verify');//验证手机号码是否存在
    Route::rule('registerApi','massage/Wrong/registerApi');//绑定手机号码和密码
    Route::rule('user','massage/User/userList');
    Route::rule('store_list','massage/Store/storeList');

});