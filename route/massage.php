<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/3/18
 * Time: 15:05
 */

Route::domain('massage.buymelots.com', function () {
    Route::rule('index', 'massage/Index/index');
    Route::rule('weixinApi', 'massage/weixin/weixinApi');
    Route::rule('massage','massage/Store/massageList');
    Route::rule('GetOpenid','massage/Store/GetOpenid');
});