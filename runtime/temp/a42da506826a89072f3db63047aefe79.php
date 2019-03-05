<?php /*a:2:{s:44:"template\adminView\we_chat\we_chat_view.html";i:1550572376;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 微信管理
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

<div class="wrapper wrapper-content animated fadeIn">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>微信基础设置</h5>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 微信基础设置</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" id="wcAjax">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span class="essential">*</span>
                                                    &nbsp;&nbsp;微信公众号APPID
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" placeholder="请输入微信公众号APPID" required="required"
                                                           class="form-control" name="wc_appid" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span class="essential">*</span>
                                                    &nbsp;&nbsp;微信公众号APPSECRET</label>
                                                <div class="col-sm-10">
                                                    <input placeholder="请输入微信公众号APPSECRET" autocomplete="off"
                                                           type="text" required="required" class="form-control" name="wc_appsecret" >
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span class="essential">*</span>
                                                    &nbsp;&nbsp;微信公众号TOKEN</label>
                                                <div class="col-sm-10">
                                                    <input type="text" placeholder="请输入微信公众号TOKEN"
                                                           required="required" class="form-control" name="wc_token" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2">
                                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                                </div>
                                            </div>
                                        </form>
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

<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="/static/adminView/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<!--<script src="/static/adminView/js/demo/bootstrap-table-demo.min.js"></script>-->
<script type="text/javascript">
    var data = [];
    WeChatAjax('weChat')
    function WeChatAjax(data){
        $.ajax({
            type : 'get',
            url : "weChatFind.html?c_key="+data,
            async : false,
            dataType : 'json',
            success : function(e){
                if(e.code > 0){
                    if(data == 'weChat'){
                        let array = e.data.c_value
                        data = array
                        $('input[name="wc_appid"]').val(array.wc_appid);
                        $('input[name="wc_appsecret"]').val(array.wc_appsecret);
                        $('input[name="wc_token"]').val(array.wc_token);
                    }
                }
            },error:function (xhr) {
                if (!errorAjax(xhr.status)) {
                    return false;
                }
            }
        })
    }

    $('#wcAjax').on('submit',function (event) {
        layer.confirm('是否保存微信基础配置',function(){
            $.ajax({
                type : 'post',
                url : "weChatConfig.html?c_key=weChat",
                async : false,
                dataType : 'json',
                data:formData(),
                success : function(e){
                    layer.close(index);
                    if(e.code < 0){
                        errorMsg(e.msg)
                    }else{
                        parent.layer.close(name);
                    }
                },error:function (xhr) {
                    if (!errorAjax(xhr.status)) {
                        return false;
                    }
                },beforeSend:function(){
                    index = layer.msg('微信基础设置修改中。。。', {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                }
            })
        })
        event.preventDefault();
    })
</script>

</body>
</html>