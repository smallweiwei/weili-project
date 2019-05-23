<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/2/20
 * Time: 11:42
 */
Route::domain('admin.buymelots.com', function () {
    Route::rule('/', 'admin/index/index');//后台首页路由
    Route::rule('menu','admin/Basic/menu');//左边菜单路由
    Route::rule('login', 'admin/login/index');//登录页面路由
    Route::rule('/index', 'admin/index/Welcome');//显示主页路由
    Route::rule('api_login', 'admin/login/login');//登录验证路由
    Route::rule('logout', 'admin/login/logout');//退出登录路由
    Route::rule('api_admin_id', 'admin/Basic/adminId');//获取登录管理员id
    Route::rule('upload','admin/Basic/upload','GET|POST');//上传图片
    Route::rule('upload_view','admin/Basic/uploadView');//上传图片页面
    Route::rule('conversion','admin/Basic/toPinyin');//上传图片页面


//管理员管理-管理员列表操作路由  start
    Route::rule('managerView','admin/manager/managerView');//管理员列表页面
    Route::rule('managerList','admin/manager/managerList');//获取管理员列表
    Route::rule('managerAddView','admin/manager/managerAddView');//获取管理员列表
    Route::rule('managerState','admin/manager/managerState','GET|POST');//修改角色状态路由
    Route::rule('managerAdd','admin/manager/managerAdd','GET|POST');//添加管理员页面
    Route::rule('managerName','admin/manager/managerName','POST');//检测管理员名称是否存在
    Route::rule('managerSaveView','admin/manager/managerSaveView');//修改管理员页面
    Route::rule('managerSave','admin/manager/managerSave','GET|POST');//修改管理员页面
    Route::rule('managerDel','admin/manager/managerDel','GET|POST');//修改管理员页面

//管理员管理-管理员列表操作路由  end

//管理员管理-角色列表操作路由  start
    Route::rule('roleView','admin/manager/roleView');//角色页面
    Route::rule('roleAddView','admin/manager/roleAddView');//角色添加/修改页面
    Route::rule('roleList','admin/manager/roleList');//获取角色列表
    Route::rule('roleState','admin/manager/roleState','GET|POST');//修改角色状态路由
    Route::rule('roleAdd', 'admin/manager/roleAdd','GET|POST'); //添加角色路由
    Route::rule('roleSave', 'admin/manager/roleSave','GET|POST'); //修改角色
    Route::rule('roleDel', 'admin/manager/roleDel','GET'); //修改角色
    Route::rule('api_role', 'admin/manager/apiRole','GET'); //获取角色列表api

//管理员管理-角色列表操作路由  end

//管理员管理-权限列表操作路由  start
    Route::rule('authView','admin/manager/authView');//权限页面
    Route::rule('authList', 'admin/manager/authList');//权限列表
    Route::rule('authState','admin/manager/authState','GET|POST');//修改权限状态
    Route::rule('authSort','admin/manager/authSort','GET|POST');//修改权限排序
    Route::rule('authAddView','admin/manager/authAddView');//添加权限页面
    Route::rule('authAdd','admin/manager/authAdd');//添加权限方法
    Route::rule('authSave','admin/manager/authSave','GET|POST');//修改权限
    Route::rule('authDel','admin/manager/authDel','GET');//删除权限
//管理员管理-权限列表操作路由  end

//微信管理 start
    Route::rule('weChatView','admin/WeChat/weChatView');//权限页面
    Route::rule('weChatConfig','admin/WeChat/weChatConfig');//添加微信基础设置
    Route::rule('weChatFind','admin/WeChat/weChatFind','GET');//添加微信基础设置
//微信管理 end

//门店管理 start
    Route::rule('store_list_view','admin/store/storeListView');//门店列表页面
    Route::rule('store_list','admin/store/storeList'); //获取门店列表
    Route::rule('store_add_view','admin/store/storeAddView'); //添加门店页面
    Route::rule('store_add','admin/store/storeAdd'); //添加门店信息方法
    Route::rule('store_save_view','admin/store/storeSaveView'); //显示修改门店信息页面路由
    Route::rule('store_save','admin/store/storeSave'); //修改门店信息方法
    Route::rule('store_del','admin/store/storeDel'); //删除门店信息方法

    Route::rule('store_staff_list_view','admin/store/storeStaffListView'); //显示门店员工页面
    Route::rule('store_staff_list','admin/store/storeStaffList'); //获取门店员工列表
    Route::rule('store_staff_add_view','admin/store/storeStaffAddView'); //显示添加门店员工页面
    Route::rule('store_staff_add','admin/store/storeStaffAdd'); //添加门店员工方法
    Route::rule('store_staff_save_view','admin/store/storeStaffSaveView'); //显示修改门店员工页面
    Route::rule('store_staff_save','admin/store/storeStaffSave'); //修改门店员工方法
    Route::rule('store_staff_del','admin/store/storeStaffDel'); //删除门店员工方法


//门店管理 end

//推拿管理  start
    Route::rule('store_massage_list_view','admin/StoreMassage/StoreMassageListView');//推拿门店 门店列表
    Route::rule('store_massage_list','admin/StoreMassage/StoreMassageList','POST');//推拿门店 门店列表
    Route::rule('store_massage_add_view','admin/StoreMassage/StoreMassageAddView');//推拿门店 添加推拿门店页面
    Route::rule('store_massage_add','admin/StoreMassage/StoreMassageAdd');//推拿门店 添加推拿门店方法

    Route::rule('store_massage_save_view','admin/StoreMassage/StoreMassageSaveView');//推拿门店 添加推拿门店页面
    Route::rule('store_massage_save','admin/StoreMassage/StoreMassageSave','GET|POST');//推拿门店 添加推拿门店方法

    Route::rule('massage_store_del','admin/StoreMassage/StoreMassageDel');//推拿门店 删除推拿门店方法
    Route::rule('massage_store','admin/StoreMassage/MassageStore');//获取全部推拿门店列表

    Route::rule('staff_list_view','admin/StoreMassage/staffListView');//显示推拿门店 员工列表
    Route::rule('staff_list','admin/StoreMassage/staffList');//获取推拿门店员工列表
    Route::rule('massage_personnel_add_view','admin/StoreMassage/staffAddView');//显示推拿门店 员工列表
    Route::rule('massage_personnel_add','admin/StoreMassage/staffAdd');//显示推拿门店 员工列表
    Route::rule('massage_personnel_save','admin/StoreMassage/staffSave');//显示推拿门店 员工列表
    Route::rule('massage_personnel_del','admin/StoreMassage/staffDel');//显示推拿门店 员工列表

    Route::rule('massage_store_list','admin/StoreMassage/massageStoreList');//获取推拿门店员工

    Route::rule('scheduling_view','admin/StoreMassage/schedulingView');//显示排班设置页面
    Route::rule('scheduling_list','admin/StoreMassage/schedulingList','POST');//获取排班设置页面
    Route::rule('scheduling_add','admin/StoreMassage/schedulingAdd','POST');//添加排班时间方法
    Route::rule('scheduling_save','admin/StoreMassage/schedulingSave','POST');//修改排班时间
    Route::rule('scheduling_del','admin/StoreMassage/schedulingDel','DELETE');//删除指定排班时间

    Route::rule('subscribe_list_view','admin/StoreMassage/SubscribeListView');

//推拿管理  end

});