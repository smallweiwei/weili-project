<?php /*a:2:{s:42:"template\adminView\public\upload_view.html";i:1551755595;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 门店列表
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
    
<link href="/static/adminView/plugins/webuploader/webuploader.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/static/adminView/plugins/webuploader/webuploader-demo.min.css">

</head>
<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <!--<div class="ibox-content">-->
            <div class="page-container">
                <div id="uploader" class="wu-example">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker"></div>
                            <div>或将照片拖到这里，单次最多可选 <span id="upload_num"></span> 张</div>
                            <!--<p>或将照片拖到这里，单次最多可选</p><p id="upload_num"></p><p>张</p>-->
                        </div>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress">
                            <span class="text">0%</span>
                            <span class="percentage"></span>
                        </div>
                        <div class="info"></div>
                        <div class="btns">
                            <div id="filePicker2"></div>
                            <div class="uploadBtn">开始上传</div>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/static/adminView/js/function.js"></script>
<script type="text/javascript" src="/static/adminView/js/plugins/layer/layer.js"></script>
<script type="text/javascript" src="/static/adminView/plugins/bootstrap/bootstrap.min.js"></script>

<script type="text/javascript">
    var array = parent.parent()//父页面数据
    var BASE_URL = 'js/plugins/webuploader';
    var UPLOAD_URL = array.url;
    var UPLOAD_NUM = array.num;
    $('#upload_num').html(array.num)
</script>
<script src="/static/adminView/plugins/webuploader/webuploader.min.js"></script>
<script src="/static/adminView/plugins/webuploader/webuploader-demo.min.js"></script>
<script type="text/javascript">

    var callbackdata = function () {
        return $('#img_pic').val();
    }

</script>

</body>
</html>