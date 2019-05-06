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
    Route::rule('', 'massage/Index/index');//显示门店列表页面
    Route::rule('index', 'massage/Index/index');//显示门店列表页面
    Route::rule('weixinApi', 'massage/Weixin/weixinApi');
    Route::rule('store','massage/Store/massageList');//门店预约详情页面
    Route::rule('error','massage/Wrong/index');//显示在微信打开页面
    Route::rule('register','massage/Wrong/register');//显示绑定手机号码页面
    Route::rule('verifyName','massage/Wrong/verify');//验证手机号码是否存在
    Route::rule('registerApi','massage/Wrong/registerApi');//绑定手机号码和密码
    Route::rule('store_list','massage/Store/storeList');//获取门店列表信息
    Route::rule('reser_form','massage/Store/reser_from','POST');//提交预约信息
    Route::rule('user','massage/User/userList');//个人中心页面
    Route::rule('reserList','massage/User/reserList','GET');//提交预约信息
    Route::rule('reser_cancel','massage/User/reserCancel','POST');//取消预约
});