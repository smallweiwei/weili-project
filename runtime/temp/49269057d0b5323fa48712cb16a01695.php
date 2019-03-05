<?php /*a:2:{s:61:"template\adminView\store_massage\store_massage_list_view.html";i:1551686683;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 推拿门店列表
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
            <h5>推拿门店列表</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <div class="example-wrap">
                        <div class="example">
                            <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                <button type="button" class="btn btn-outline btn-default" onclick="manager_add('添加门店','managerAddView.html','850','450')" >
                                    <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                                    添加推拿门店
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
<script type="text/javascript">
    $(function () {
        storeMassageAjax()
    })
    
    function storeMassageAjax() {
        $("#exampleTableEvents").bootstrapTable('destroy');//清除table
        $("#exampleTableEvents").bootstrapTable({
            url: "store_massage_list.html",
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
            sortName : 'sm_id',
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
                    title: '门店名称',
                    align: 'center',
                },
                {
                    field: 'ag_title',
                    title: '门店地址',
                    align: 'center',
                },
                {
                    field: 'ag_title',
                    title: '门店电话',
                    align: 'center',
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
                        return  html
                    }
                }
            ]
        });
    }
</script>

</body>
</html>