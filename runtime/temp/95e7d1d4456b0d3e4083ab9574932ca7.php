<?php /*a:2:{s:44:"template\adminView\manager\manager_view.html";i:1550648354;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 管理员列表
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
            <h5>管理员列表</h5>
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
                        <!--<h4 class="example-title">事件</h4>-->
                        <div class="example">
                            <!-- <div class="alert alert-success" id="examplebtTableEventsResult" role="alert">
                                事件结果
                            </div> -->
                            <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                <button type="button" class="btn btn-outline btn-default" onclick="manager_add('添加管理员','managerAddView.html','850','450')" >
                                    <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                                    添加管理员
                                </button>


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

<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<!--<script src="/static/adminView/js/demo/bootstrap-table-demo.min.js"></script>-->
<script type="text/javascript">
    $(function () {
        managerAjax()
    })

    function managerAjax() {
        $("#exampleTableEvents").bootstrapTable('destroy');//清除table
        $("#exampleTableEvents").bootstrapTable({
            url: "managerList.html",
            method : 'post',
            search: !0,
            pagination: !0,
            showRefresh: !0,
            showColumns: !0,
            iconSize: "outline",
            sortable: !0,
            toolbar: "#exampleTableEventsToolbar",
            pageSize: 20,//每页显示多少条数据
            sidePagination: "client",
            pageList: [20, 25, 50, 100],
            sortName : 'm_id',
            sortOrder : 'asc',
            icons: {
                refresh: "glyphicon-repeat",
                toggle: "glyphicon-list-alt",
                columns: "glyphicon-list"
            },
            columns: [
                {
                    field: 'm_id',
                    align: 'center',
                    title: '编号',
                },
                {
                    field: 'm_name',
                    title: '管理员名称',
                    align: 'center',
                },
                {
                    field: 'ag_title',
                    title: '角色',
                    align: 'center',
                },
                {
                    field: 'm_sex',
                    title: '性别',
                    align: 'center',
                    formatter: function (value) {
                        if(value == '1'){
                            return '男'
                        }else if(value == '2'){
                            return '女'
                        }else{
                            return '保密'
                        }
                    }
                },
                {
                    field: 'm_state',
                    title: '状态',
                    align: 'center',
                    formatter:function (value,row,index) {
                        if(value == '2'){
                            return '<span class="label label-default radius">已停用</span>'
                        }else{
                            return '<span class="label label-success radius">已启用</span>'
                        }
                    }
                },
                {
                    field: 'm_addTime',
                    title: '添加时间',
                    align: 'center',
                },
                {
                    field: 'm_id',
                    title: '操作',
                    align: 'center',
                    formatter: function (value, row) {
                        var html = '';
                        if(row.m_state == '2'){
                            html += '<span style="margin-right: 5px"' +
                                ' onclick="manager_state(\'启用\',\'1\',\''+value+'\',\''+row.m_name+'\',\''+row.ag_id+'\')">' +
                                '<a href="javascript:;">启用</a></span>';
                        }else{
                            html += '<span style="margin-right: 5px"' +
                                ' onclick="manager_state(\'停用\',\'2\',\''+value+'\',\''+row.m_name+'\',\''+row.ag_id+'\')">' +
                                '<a href="javascript:;" >停用</a></span>';
                        }
                        html += '<span style="margin-right: 5px" ' +
                            'onclick="manager_save(\'修改管理员[ '+row.m_name+' ]\',\'managerSaveView.html\',800,500,'+JSON.stringify(row).replace(/"/g, '&quot;')+')">' +
                            '<a href="javascript:;" >修改</a></span>';

                        html += '<span style="margin-right: 5px" ' +
                            'onclick="manager_del(this,\''+value+'\',\''+row.m_name+'\')">' +
                            '<a href="javascript:;" >删除</a></span>';
                        // html += '<a href="" >删除</a>';
                        //通过formatter可以自定义列显示的内容
                        //value：当前field的值，即id
                        //row：当前行的数据
                        return  html
                    }
                }
            ]
        });
    }
    
    /**
     * 显示添加管理员页面
     * @param title
     * @param url
     * @param w
     * @param h
     */
    function manager_add(title,url,w,h) {
        layerShow(title,url,w,h);
    }

    /**
     * 修改管理员状态
     * @param title
     * @param m_start
     * @param m_id
     * @param m_name
     * @param ag_id
     */
    function manager_state(title,m_start,m_id,m_name,ag_id) {
        layer.confirm('确认要'+title+'['+m_name+']吗?',function(){
            $.ajax({
                type : 'post',
                url : "managerState.html?m_id="+m_id+"&ag_id="+ ag_id,
                async : true,
                dataType : 'json',
                data:{
                    'm_state':m_start,
                },
                success : function(e){
                    if(e.code < 0){
                        errorMsg(e.msg)
                    }else{
                        managerAjax()
                    }
                },error:function (xhr) {
                    if(!errorAjax(xhr.status)){
                        return false;
                    }
                }
            })
            layer.closeAll();//关闭确认弹框
        })
    }

    var array = [];
    /**
     * 显示修改管理员信息页面
     * @param title 弹框标题
     * @param url 路由地址
     * @param w 宽
     * @param h 高
     */
    function manager_save(title,url,w,h,data) {
        array = data
        layerShow(title,url,w,h);
    }
    var admin = getAdminID()
    /**
     * 给子页面传值
     * @returns {Array}  返回数组给子页面
     */
    function parent() {
        var data = [];
        data['data'] = array
        data['admin'] = admin
        return data
    }

    /**
     * 删除管理员信息（伪删除）
     * @param obj
     * @param m_id
     * @param m_name
     */
    function manager_del(obj,m_id = '',m_name = '') {
        if(m_id == ''){
            errorMsg('删除失败')
        }else{
            layer.confirm('确认要删除['+m_name+']管理员吗?',function(){
                $.ajax({
                    type : 'post',
                    url : "managerDel.html?m_id="+m_id,
                    async : true,
                    dataType : 'json',
                    data:{
                        m_delete:2,
                    },
                    success : function(e){
                        if(e.code < 0){
                            errorMsg(e.msg)
                        }else{
                            managerAjax()
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