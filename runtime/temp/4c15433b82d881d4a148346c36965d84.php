<?php /*a:2:{s:41:"template\adminView\manager\role_view.html";i:1550157458;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 角色列表
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
            <h5>角色列表</h5>
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
                        <div class="example">
                            <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                <button type="button" class="btn btn-outline btn-default"
                                        onclick="role_add('添加角色','roleAddView.html','850','400','','1')">
                                    <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                                    添加角色
                                </button>

                                <!--<button type="button" class="btn btn-outline btn-default">-->
                                    <!--<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>-->
                                    <!--批量删除-->
                                <!--</button>-->
                            </div>
                            <table id="exampleTableEvents" data-mobile-responsive="true">
                            </table>
                        </div>
                    </div>
                    <!-- End Example Events -->
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/static/adminView/js/function.js"></script>
<script type="text/javascript" src="/static/adminView/js/plugins/layer/layer.js"></script>
<script type="text/javascript" src="/static/adminView/plugins/bootstrap/bootstrap.min.js"></script>

<script type="text/javascript" src="/static/adminView/js/function.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script type="text/javascript">
    $(function () {
        roleAjax()
    })

    var roleDivision = ''
    var array = new Array();
    var roleData = new Array();

    /**
     * 获取角色列表
     */
    function roleAjax(){
        $("#exampleTableEvents").bootstrapTable('destroy');//清除table
        $("#exampleTableEvents").bootstrapTable({
            url: "roleList.html",
            ajaxOptions: {async:true,timeout:5000},
            search: !0,
            pagination: !0,
            showRefresh: !0,
            showColumns: !0,
            iconSize: "outline",
            sortable: !0,
            toolbar: "#exampleTableEventsToolbar",
            pageSize: 10,//每页显示多少条数据
            sidePagination: "client",
            pageList: [10, 25, 50, 100],
            sortName : 'ag_id',
            sortOrder : 'asc',
            icons: {
                refresh: "glyphicon-repeat",
                toggle: "glyphicon-list-alt",
                columns: "glyphicon-list"
            },
            columns: [
                {
                    field: 'ag_id',
                    align: 'center',
                    title: '编号',
                },
                {
                    field: 'ag_title',
                    title: '角色名称',
                    align: 'center',
                },
                {
                    field: 'ag_describe',
                    title: '描述',
                    align: 'center',
                },
                {
                    field: 'ag_status',
                    title: '状态',
                    align: 'center',
                    class:'ag_status',
                    formatter:function (value,row,index) {
                        if(value == '2'){
                            return '<span class="label label-default radius">禁用</span>'
                        }else{
                            return '<span class="label label-success radius">启用</span>'
                        }
                    }
                },
                {
                    field: 'ag_addTime',
                    title: '添加时间',
                    align: 'center',
                },
                {
                    field: 'ag_id',
                    title: '操作',
                    align: 'center',
                    class:'operation',
                    formatter: function (value, row, index) {
                        var html = '';
                        if(row.ag_status == '2'){
                            html += '<span style="margin-right: 5px" onclick="state(this,\'启用\',\'1\',\''+value+'\')"><a href="javascript:;">启用</a></span>';
                        }else{
                            html += '<span style="margin-right: 5px" onclick="state(this,\'禁用\',\'2\',\''+value+'\')"><a href="javascript:;" >禁用</a></span>';
                        }
                        html += '<span style="margin-right: 5px"' +
                            ' onclick="role_add(\'修改['+row.ag_title+']角色\',\'roleAddView.html\',\'850\',\'400\',\''+row.ag_title+'\',\'2\',\''+value+'\')">' +
                            '<a href="javascript:;" >修改</a></span>';
                        html += '<span style="margin-right: 5px"' +
                            ' onclick="role_del(this,\''+value+'\',\''+row.ag_title+'\')">' +
                            '<a href="javascript:;">删除</a></span>';
                        return  html
                    }
                }
            ],
            onLoadSuccess:function (e) {
                array = e.data
            }
        });
    }

    /**
     *  修改角色状态
     * @param obj 当前点击
     * @param title 禁用还是启用
     * @param ag_state 角色状态码
     * @param ag_id 角色id
     */
    function state(obj,title,ag_state,ag_id) {
        console.log(title)
        $.ajax({
            type: "POST",
            url: "roleState.html?ag_id="+ag_id,
            dataType: "json",
            crossDomain: true,
            data: {
                ag_status:ag_state,
            },success: function (data) {
                if(data.code < 0){
                    errorMsg(data.msg)
                }else{
                    // roleAjax()
                    var html = ''
                    var span = ''
                    if(ag_state == 1){
                        html += '<span class="label label-success radius">启用</span>'
                        $(obj).parent().parent().children('.ag_status').html(html)
                        span += '<span style="margin-right: 5px" onclick="state(this,\'禁用\',\'2\',\''+ag_id+'\')"><a href="javascript:;" >禁用</a></span>';
                        $(obj).before(span)
                        $(obj).remove()
                    }else{
                        html += '<span class="label label-default radius">禁用</span>'
                        span += '<span style="margin-right: 5px" onclick="state(this,\'启用\',\'1\',\''+ag_id+'\')"><a href="javascript:;">启用</a></span>';
                        $(obj).parent().parent().children('.ag_status').html(html)
                        $(obj).before(span)
                        $(obj).remove()
                    }
                }
            }
        })
    }

    /**
     * 显示添加角色页面
     * @param title
     * @param url
     * @param w
     * @param h
     * @param ar_title  显示权限中文名称
     * @param ar_id  当ar_id 为空时是父权限  有值为子权限
     * @param num  1 为添加角色  2为修改角色
     */
    function role_add(title,url,w,h,ar_title = '',num = '1',ar_id = '') {
        var data = new Array();
        if(ar_id != ''){
            $.each(array,function (k,v) {
                if(this.ag_id == ar_id){
                    data = v
                }
            })
        }
        roleDivision = num
        roleData = data
        layerShow(title,url,w,h);
    }

    /**
     * 给子页面传值
     * @returns {Array}  返回数组给子页面
     */
    function parent() {
        var data = [];
        data['roleDivision'] = roleDivision
        data['roleData'] = roleData
        return data
    }

    /**
     * 删除角色
     * @param obj
     * @param ag_id 角色id
     * @param ag_title  角色名称
     */
    function role_del(obj,ag_id = '',ag_title='') {
        if(ag_id == ''){
            errorMsg('删除失败')
        }else{
            layer.confirm('确认要删除['+ag_title+']角色吗?',function(){
                $.ajax({
                    type : 'get',
                    url : "roleDel.html?ag_id="+ag_id,
                    async : true,
                    dataType : 'json',
                    data:formData(),
                    success : function(e){
                        if(e.code < 0){
                            errorMsg(e.msg)
                        }else{
                            roleAjax()
                        }
                    },error:function (xhr) {
                        if(!errorAjax(xhr.status)){
                            return false;
                        }
                    }
                })
                layer.closeAll('dialog');
            })

        }
    }

</script>

</body>
</html>