<?php /*a:2:{s:44:"template\adminView\store\store_add_view.html";i:1551755001;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 添加门店信息
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
    


</head>
<body class="gray-bg">

<div class="col-sm-12" style="padding: 0">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <form method="post" class="form-horizontal" id="addAjax" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <span class="essential">*</span>
                        &nbsp;&nbsp;门店名称</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="请输入门店名称" required="required" class="form-control" name="s_name" autocomplete="off">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <span class="essential">*</span>
                        &nbsp;&nbsp;门店地址</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="请输入门店地址"
                               required="required" class="form-control" name="s_address" autocomplete="off">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        门店电话</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="请输入门店电话" class="form-control" name="s_phone"
                               autocomplete="off">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                       门店图片</label>
                    <div class="col-sm-10">
                        <!--<input type="file" name="s_pic" id="s_pic">-->
                        <input type="text" class="form-control" name="s_pic" onclick="clickUpload()">
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

<script type="text/javascript" src="/static/adminView/js/function.js"></script>
<script type="text/javascript" src="/static/adminView/js/plugins/layer/layer.js"></script>
<script type="text/javascript" src="/static/adminView/plugins/bootstrap/bootstrap.min.js"></script>

<script type="text/javascript">
    $('#addAjax').on('submit',function (event) {
        event.preventDefault();
    })
    
    function clickUpload() {
        // layerShow('上传图片','upload_view.html','820','480');
        layer.open({
            type: 2,
            title: '上传图片',
            shadeClose: false,
            btn:['确定','取消'],
            shade: 0.8,
            closeBtn:0,
            area: ['820px', '550px'],
            content: 'upload_view.html',
            yes:function(n){
                var iframeWin1 = window["layui-layer-iframe" + n];
                var res = iframeWin1.callbackdata();
                console.log(res)
            },
        });
    }

    /**
     * 给子页面传值
     * @returns {Array}  返回数组给子页面
     */
    function parent() {
        var data = [];
        data['url'] = 'upload.html?name=store';
        data['num'] = '1';
        return data
    }

</script>


</body>
</html>