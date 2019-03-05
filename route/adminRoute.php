<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/2/20
 * Time: 11:42
 */
Route::domain('admin.buymelots.com', function () {
    Route::rule('/', 'admin/Index/index');//后台首页路由
    Route::rule('menu','admin/Basic/menu');//左边菜单路由
    Route::rule('login', 'admin/Login/index');//登录页面路由
    Route::rule('/index', 'admin/Index/Welcome');//显示主页路由
    Route::rule('api_login', 'admin/Login/Login');//登录验证路由
    Route::rule('logout', 'admin/Login/logout');//退出登录路由
    Route::rule('api_admin_id', 'admin/Basic/adminId');//获取登录管理员id

    Route::rule('upload','admin/Basic/upload','GET|POST');//上传图片
    Route::rule('upload_view','admin/Basic/uploadView');//上传图片


//管理员管理-管理员列表操作路由  start
    Route::rule('managerView','admin/Manager/managerView');//管理员列表页面
    Route::rule('managerList','admin/Manager/managerList');//获取管理员列表
    Route::rule('managerAddView','admin/Manager/managerAddView');//获取管理员列表
    Route::rule('managerState','admin/Manager/managerState','GET|POST');//修改角色状态路由
    Route::rule('managerAdd','admin/Manager/managerAdd','GET|POST');//添加管理员页面
    Route::rule('managerName','admin/Manager/managerName','POST');//检测管理员名称是否存在
    Route::rule('managerSaveView','admin/Manager/managerSaveView');//修改管理员页面
    Route::rule('managerSave','admin/Manager/managerSave','GET|POST');//修改管理员页面
    Route::rule('managerDel','admin/Manager/managerDel','GET|POST');//修改管理员页面

//管理员管理-管理员列表操作路由  end

//管理员管理-角色列表操作路由  start
    Route::rule('roleView','admin/Manager/roleView');//角色页面
    Route::rule('roleAddView','admin/Manager/roleAddView');//角色添加/修改页面
    Route::rule('roleList','admin/Manager/roleList');//获取角色列表
    Route::rule('roleState','admin/Manager/roleState','GET|POST');//修改角色状态路由
    Route::rule('roleAdd', 'admin/Manager/roleAdd','GET|POST'); //添加角色路由
    Route::rule('roleSave', 'admin/Manager/roleSave','GET|POST'); //修改角色
    Route::rule('roleDel', 'admin/Manager/roleDel','GET'); //修改角色
    Route::rule('api_role', 'admin/Manager/apiRole','GET'); //获取角色列表api

//管理员管理-角色列表操作路由  end

//管理员管理-权限列表操作路由  start
    Route::rule('authView','admin/Manager/authView');//权限页面
    Route::rule('authList', 'admin/Manager/authList');//权限列表
    Route::rule('authState','admin/Manager/authState','GET|POST');//修改权限状态
    Route::rule('authSort','admin/Manager/authSort','GET|POST');//修改权限排序
    Route::rule('authAddView','admin/Manager/authAddView');//添加权限页面
    Route::rule('authAdd','admin/Manager/authAdd');//添加权限方法
    Route::rule('authSave','admin/Manager/authSave','GET|POST');//修改权限
    Route::rule('authDel','admin/Manager/authDel','GET');//删除权限
//管理员管理-权限列表操作路由  end

//微信管理 start
    Route::rule('weChatView','admin/WeChat/weChatView');//权限页面
    Route::rule('weChatConfig','admin/WeChat/weChatConfig');//添加微信基础设置
    Route::rule('weChatFind','admin/WeChat/weChatFind','GET');//添加微信基础设置
//微信管理 end

//门店管理 start
    Route::rule('storeListView','admin/Store/storeListView');//门店列表页面
    Route::rule('storeList','admin/Store/storeList','POST'); //获取门店列表
    Route::rule('storeAddView','admin/Store/storeAddView'); //添加门店页面
    Route::rule('storeAdd','admin/Store/storeAdd'); //添加门店信息方法
//门店管理 end

//推拿管理  start store_massage_list_view
    Route::rule('store_massage_list_view','admin/StoreMassage/StoreMassageListView');//推拿门店 门店列表
    Route::rule('store_massage_list','admin/StoreMassage/StoreMassageList','POST');//推拿门店 门店列表

//推拿管理  end

});