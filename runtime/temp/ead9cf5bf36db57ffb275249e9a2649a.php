<?php /*a:2:{s:41:"template\adminView\manager\auth_view.html";i:1550157583;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 权限列表
    </title>
    <link href="/static/adminView/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/static/adminView/css/font-awesome.min.css" rel="stylesheet">
    <link href="/static/adminView/css/animate.min.css" rel="stylesheet">
    <link href="/static/adminView/css/style.min.css" rel="stylesheet">
    <link href="/static/adminView/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/static/adminView/css/public.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <style type="text/css">
        .essential{
            color: red;
            font-size: 16px;
        }
        .radio-box {
            display: inline-block;
            box-sizing: border-box;
            cursor: pointer;
            position: relative;
            padding-left: 30px;
            padding-right: 20px;
        }
    </style>
    
<style type="text/css">

</style>

</head>
<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>权限列表</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <!-- Example Events -->
                    <div class="example-wrap">
                        <div class="example bootstrap-table">
                            <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                <button type="button" class="btn btn-outline btn-default" onclick="auth_add('添加权限','authAddView.html','850','450','')" >
                                    <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                                    添加权限
                                </button>
                            </div>
                            <div class="fixed-table-container fixed-table-body">
                                <div class="fixed-table-container" style="padding-bottom: 0px;">
                                    <div class="fixed-table-body">
                                        <table id="exampleTableEvents" data-mobile-responsive="true" class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center; " data-field="ar_id">
                                                    <div class="th-inner ">编号</div>
                                                </th>
                                                <th style="text-align: center; " data-field="ar_title">
                                                    <div class="th-inner ">权限中文名称</div>
                                                </th>
                                                <th style="text-align: center; " data-field="ag_name">
                                                    <div class="th-inner ">英文名称</div>
                                                    <div class="fht-cell"></div>
                                                </th>
                                                <th style="text-align: center; " data-field="m_sex">
                                                    <div class="th-inner ">类型</div>
                                                    <div class="fht-cell"></div>
                                                </th>
                                                <th style="text-align: center; " data-field="ar_icon">
                                                    <div class="th-inner ">菜单图标</div>
                                                    <div class="fht-cell"></div>
                                                </th>
                                                <th style="text-align: center; " data-field="ar_status">
                                                    <div class="th-inner ">状态</div>
                                                    <div class="fht-cell"></div>
                                                </th>
                                                <th style="text-align: center; width: 150px" data-field="ar_sort" >
                                                    <div class="th-inner ">排序</div>
                                                    <div class="fht-cell"></div>
                                                </th>
                                                <th style="text-align: center; " data-field="ar_id">
                                                    <div class="th-inner ">操作</div>
                                                    <div class="fht-cell"></div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/static/adminView/js/function.js"></script>
<script type="text/javascript" src="/static/adminView/js/plugins/layer/layer.js"></script>
<script type="text/javascript" src="/static/adminView/plugins/bootstrap/bootstrap.min.js"></script>


<!--<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>-->
<!--<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>-->
<!--<script src="/static/adminView/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>-->


<script type="text/javascript">
    var array = [] //定义数组存放权限列表
    var categoryTitle = ''//定义父权限的名称
    var pid = 0 // 区分是父权限还是子权限
    var categoryState = '' //区分是添加还是修改 0为添加 1为修改
    var categoryId = 0 //权限id 默认为0

    authAjax() //查询权限列表并显示

    /**
     * 处理权限列表ajax
     */
    function authAjax() {
        var index = null
        $.ajax({
            type : 'get',
            url : "authList.html",
            async : false,
            dataType : 'json',
            data:{
                sort:'ar_sort',
                order: 'asc',
                limit: 10,
                offset: 0
            },
            success : function(e){
                layer.close(index);
                if(e.code < 0){
                    layer.msg(data.msg,{time: 1700, icon:5});
                }else{
                    array = e.data //查询出的数据赋值到array
                    authorityList(e.data)
                }
            },beforeSend:function(){
                index = layer.msg('权限列表获取中。。。', {
                    icon: 16,
                    shade: 0.4,
                    time:false //取消自动关闭
                });
            },
        })
    }

    /**
     * 显示权限列表
     */
    function authorityList(array) {
        $('#exampleTableEvents tbody').html('');
        var html = '';
        $.each(array,function (key,val) {
            html += '<tr data-index="'+val.ar_id+'">'
            html += '<td style="text-align: center; ">'+(key+1)+'</td>'
            html += '<td style="text-align: center; ">'+(val.ar_title)+'</td>'
            html += '<td style="text-align: center; ">'+(val.ar_name)+'</td>'
            html += '<td style="text-align: center; ">控制器</td>'
            html += '<td style="text-align: center; ">'+(val.ar_icon)+'</td>'
            html += '<td class="ag_status" style="text-align: center; ">'+(auth_state(val.ar_id,val.ar_status))+'</td>'
            html += '<td style="text-align: center; ">'
            html += '<div style="width: 50%;margin: auto;">'
            html += '<input type="text" class="form-control" onblur="onblur_sort(this,'+val.ar_id+','+val.ar_sort+',this.value)" style="text-align: center" name="ar_sort" value="'+val.ar_sort+'">'
            html += '</div>'
            html += '</td>'
            html += '<td style="text-align: center; ">'+auth_operation(val.ar_id,val.ar_status,0,val.ar_title,val.ar_title,'0')+'</td>'
            html  += '</tr>'
            //隐藏子类
            if(!isArrayNull(val.ar_pid)){
                $.each(val.ar_pid,function (k,v) {
                    html += '<tr data-index="'+v.ar_id+'" class="auth auth-'+val.ar_id+'" style="display: none">'
                        html += '<td style="text-align: center; ">'+(k+1)+'</td>'
                        html += '<td style="text-align: center; ">'+(val.ar_title)+'——'+(v.ar_title)+'</td>'
                        html += '<td style="text-align: center; ">'+(v.ar_name)+'</td>'
                    html += '<td style="text-align: center; ">方法</td>'
                    html += '<td style="text-align: center; ">'+(v.ar_icon||'')+'</td>'
                        html += '<td class="ag_status" style="text-align: center; ">'+(auth_state(v.ar_id,v.ar_status))+'</td>'
                        html += '<td style="text-align: center; ">'
                            html += '<div style="width: 50%;margin: auto;">'
                                html += '<input type="text" class="form-control" onblur="onblur_sort(this,'+v.ar_id+','+v.ar_sort+',this.value)" style="text-align: center" name="ar_sort" value="'+v.ar_sort+'">'
                            html += '</div>'
                        html += '</td>'
                    html += '<td style="text-align: center; ">'+auth_operation(v.ar_id,v.ar_status,1,v.ar_title,val.ar_title,val.ar_id)+'</td>'
                    html += '</tr>'
                })
            }

        })
        $('#exampleTableEvents tbody').html(html);
    }

    /**
     *  修改权限状态
     * @param obj 操作的当前数据
     * @param title  禁用或者启用
     * @param ar_status  1 or 2
     * @param ar_id  权限id
     */
    function state(obj,title,ar_status,ar_id) {
        layer.confirm('确认要'+title+'该权限吗？',function(){
            $.ajax({
                type: "POST",
                url: "authState.html?ar_id="+ar_id,
                dataType: "json",
                crossDomain: true,
                data: {
                    ar_status:ar_status,
                },
                success: function (data) {
                    if(data.code < 0){
                        errorMsg(data.msg)
                    }else{
                        var html = ''
                        var span = ''
                        if(ar_status == 1){
                            html += '<span class="label label-success radius">启用</span>'
                            $(obj).parent().parent().children('.ag_status').html(html)
                            span += '<span style="margin-right: 5px" onclick="state(this,\'禁用\',\'2\',\''+ar_id+'\')"><a href="javascript:;" >禁用</a></span>';
                            $(obj).before(span)
                            $(obj).remove()
                        }else{
                            html += '<span class="label label-default radius">禁用</span>'
                            span += '<span style="margin-right: 5px" onclick="state(this,\'启用\',\'1\',\''+ar_id+'\')"><a href="javascript:;">启用</a></span>';
                            $(obj).parent().parent().children('.ag_status').html(html)
                            $(obj).before(span)
                            $(obj).remove()

                        }
                    }
                }
            })
            layer.closeAll('dialog');
        })

    }

    /**
     * 显示权限状态样式
     * @param ag_id 权限id
     * @param ag_state  权限状态
     * @returns {string}
     */
    function auth_state(ag_id,ag_state) {
        if(ag_state == 1){
            return '<span class="label label-success radius">启用</span>'
        }else{
            return '<span class="label label-default radius">禁用</span>'
        }
    }

    /**
     * 显示操作HTML 样式
     * @param ag_id
     * @param ag_state
     * @returns {string}
     */
    function auth_operation(ar_id,ar_status,num,title,ar_title,ar_pid) {
        var html = '';
        if(num != 1){
            html += '<span style="margin-right: 5px" onclick="open_subclass(this,\''+ar_id+'\',1)">' +
                '<a href="javascript:;">展开</a></span>';
            html += '<span style="margin-right: 5px" ><a href="javascript:;" ' +
                'onclick="auth_add(\'添加子权限\',\'authAddView.html\',\'850\',\'450\',\''+title+'\',\''+ar_id+'\')">' +
                '添加子权限</a></span>';
        }

        html += '<span style="margin-right: 5px" ' +
            'onclick="auth_save(\'修改'+title+'\',\'authAddView.html\',\'850\',\'450\',\''+ar_title+'\',\''+ar_id+'\',\''+ar_pid+'\')">' +
            '<a href="javascript:;">修改</a></span>';

        if(ar_status == '2'){
            html += '<span style="margin-right: 5px" ' +
                'onclick="state(this,\'启用\',\'1\',\''+ar_id+'\')">' +
                '<a href="javascript:;">启用</a></span>';
        }else{
            html += '<span style="margin-right: 5px"' +
                ' onclick="state(this,\'禁用\',\'2\',\''+ar_id+'\')">' +
                '<a href="javascript:;" >禁用</a></span>';
        }

        html += '<span style="margin-right: 5px" ' +
            'onclick="auth_del(this,\''+ar_id+'\')">' +
            '<a href="javascript:;">删除</a></span>';

        return html
    }

    /**
     * 权限列表 排序
     * @param obj 当前操作
     * @param ar_id 权限id
     * @param ar_sort  没有修改前排序
     * @param sort  修改的排序值
     */
    function onblur_sort(obj,ar_id,ar_sort,sort) {
        var index = null
        if(ar_sort != sort){
            $.ajax({
                type : 'post',
                url : "authSort.html?ar_id="+ar_id,
                async : true,
                dataType : 'json',
                data:{
                    ar_sort:sort,
                },
                success : function(e){
                    layer.close(index);
                    if(e.code < 0){
                        errorMsg(data.msg)
                    }else{
                        array = e.data
                        authorityList(e.data)
                    }
                },beforeSend:function(){
                    index = layer.msg('权限排序修改中。。。', {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                },
            })
        }

    }

    /**
     * 点击展开或者关闭
     * @param obj
     * @param ar_id
     * @param num
     */
    function open_subclass(obj,ar_id,num) {
        var span = ''
        if(num == 1){
            span += '<span style="margin-right: 5px" onclick="open_subclass(this,\''+ar_id+'\',2)">' +
                '<a href="javascript:;">收起</a></span>';
            var auth = $(obj).parent().parent().parent().children('.auth-'+ar_id)
            $(auth).each(function (key) {
                auth[key].style.display = ''
            })
            $(obj).before(span)
            $(obj).remove()
        }else{
            span += '<span style="margin-right: 5px" onclick="open_subclass(this,\''+ar_id+'\',1)">' +
                '<a href="javascript:;">展开</a></span>';

            var auth = $(obj).parent().parent().parent().children('.auth-'+ar_id)
            $(auth).each(function (key) {
                auth[key].style.display = 'none'
            })
            $(obj).before(span)
            $(obj).remove()
        }
    }

    /**
     * 显示添加权限页面
     * @param title
     * @param url
     * @param w
     * @param h
     * @param num  1 为添加父权限  2为添加子权限
     * @param ar_title  显示权限中文名称
     * @param ar_id  当ar_id 为空时是父权限  有值为子权限
     */
    function auth_add(title,url,w,h,ar_title = '',ar_id = '0') {
        categoryTitle = ar_title
        pid = ar_id
        categoryState = 0
        layerShow(title,url,w,h);
    }

    /**
     * 修改权限
     * @param title
     * @param url
     * @param w
     * @param h
     * @param ar_id
     */
    function auth_save(title,url,w,h,ar_title = '',ar_id,ar_pid) {
        categoryState = 1
        categoryId = ar_id
        pid = ar_pid
        categoryTitle = ar_title
        layerShow(title,url,w,h)
    }

    /**
     * 权限删除
     * @param obj
     * @param ar_id 权限id
     */
    function auth_del(obj,ar_id = '') {
        if(ar_id == ''){
            errorMsg('删除失败')
        }else{
            layer.confirm('确认要删除权限吗?',function(){
                $.ajax({
                    type : 'get',
                    url : "authDel.html?ar_id="+ar_id,
                    async : true,
                    dataType : 'json',
                    data:formData(),
                    success : function(e){
                        if(e.code < 0){
                            errorMsg(e.msg)
                        }else{
                            authAjax()
                        }
                    },error:function (xhr) {
                        if(!errorAjax(xhr.status)){
                            return false;
                        }
                    }
                })
            })

        }
    }

    /**
     * 给子页面传值
     * @returns {Array}  返回数组给子页面
     */
    function parent() {
        var data = [];
        data['authArray'] = array
        data['pid'] = pid
        data['categoryTitle'] = categoryTitle
        data['state'] = categoryState
        data['categoryId'] = categoryId
        return data
    }

</script>

</body>
</html>