<?php /*a:2:{s:45:"template\adminView\manager\auth_add_view.html";i:1550629953;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 添加权限
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
    .formControls{position:relative}/*表单控制区*/
    .formControls > *{vertical-align:middle}
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

<div class="col-sm-12" style="padding: 0;">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <form method="post" class="form-horizontal addAjax">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="essential">*</span>&nbsp;&nbsp;权限名称</label>
                    <div class="col-sm-10">
                        <input type="text" autocomplete="off" required="required" class="form-control" name="ar_title">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="essential">*</span>&nbsp;&nbsp;英文名称</label>
                    <div class="col-sm-10">
                        <input type="text" required="required" autocomplete="off" class="form-control" name="ar_name">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div id="assortment" style="display: none">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">父&nbsp;&nbsp;权&nbsp;&nbsp;限</label>
                        <div class="col-sm-10" id="parent_auth">
                            <input type="text" disabled class="form-control" name="assortment" >
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div class="hidden" id="ar_pid">
                    <input type="hidden" id="pid" name="ar_pid" value=""> <!--隐藏父id-->
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型</label>
                    <div class="col-sm-10">
                        <input type="text" autocomplete="off" class="form-control" disabled name="ar_type">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div id="ar_icon" style="display: none;">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标</label>
                        <div class="col-sm-10">
                            <input type="text" autocomplete="off" class="form-control" name="ar_icon">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态</label>
                    <div class="formControls col-sm-10 skin-minimal">
                        <div class="radio-box">
                            <input type="radio" checked id="female" name="ar_status" value="1" />
                            <label for="female">启用</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="male" name="ar_status" value="2" />
                            <label for="male">禁用</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">排&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;序</label>
                    <div class="col-sm-10">
                        <input type="text" autocomplete="off" class="form-control" placeholder="不填写默认为1" name="ar_sort">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <!--<button class="btn btn-white" type="submit">取消</button>-->
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
    var array = parent.parent()//父页面数据
    var state = array.state //判断是添加还是修改
    $('#pid').val(array.pid)
    if(array.pid == '0'){
        $('input[name="ar_type"]').val('控制器');
    }else{
        $('input[name="ar_type"]').val('方法');
    }
    if(state == 0){
        if(array.pid == '0'){
            $("#ar_icon").css('display','block');
        }else{
            $('#assortment').css('display','block')
            $('input[name="assortment"]').val(array.categoryTitle);
        }

        $('.addAjax').attr('id','addAjax');
        var title = ''
        if(array.pid == '0'){
            title = '权限添加中。。。'
        }else{
            title = array.categoryTitle+'子权限添加中。。。'
        }
        //添加操作
        $('#addAjax').on('submit',function (ev) {
            var name = parent.layer.getFrameIndex(window.name);
            var index = null

            $.ajax({
                type : 'post',
                url : "authAdd.html",
                async : true,
                dataType : 'json',
                data:formData(),
                success : function(e){
                    if(e.code < 0){
                        errorMsg(e.msg)
                    }else{
                        parent.layer.close(name);
                        parent.authAjax()
                    }
                },error:function (xhr) {
                    if(!errorAjax(xhr.status)){
                        return false;
                    }
                },beforeSend:function(){
                    index = layer.msg(title, {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                },
            })
            ev.preventDefault();
        })
    }else{
        if(array.pid == '0'){
            $("#ar_icon").css('display','block');
            title = '权限修改中。。。'
        }else{
            title = '子权限修改中。。。'
        }

        $('.addAjax').attr('id','saveAjax');
        var data = array.authArray

        if(array.pid != 0){
            $('#assortment').css('display','block')
            $('#ar_pid').html('');
            var html = '';
            html += '<select class="form-control m-b" name="ar_pid">'
            $.each(data,function (key,val) {
                if(val.ar_id == array.pid){
                    html += '<option selected value="'+val.ar_id+'">'+val.ar_title+'</option>'
                }else{
                    html += '<option value="'+val.ar_id+'">'+val.ar_title+'</option>'
                }
            })
            html += '</select>'
            $('#parent_auth').html(html);
        }
        $.each(data,function (key,val) {
            if(val.ar_id == array.categoryId){
                $('input[name="ar_title"]').val(val.ar_title);
                $('input[name="ar_name"]').val(val.ar_name);
                $('input[name="ar_icon"]').val(val.ar_icon);
                $('input[name="ar_sort"]').val(val.ar_sort);
                if(val.ar_status == 1){
                    $("input[name=ar_status]:eq(0)").attr("checked",'checked');
                }else{
                    $("input[name=ar_status]:eq(1)").attr("checked",'checked');
                }
            }
            $.each(val.ar_pid,function (k,v) {
                if(v.ar_id == array.categoryId){
                    $('input[name="ar_title"]').val(v.ar_title);
                    $('input[name="ar_name"]').val(v.ar_name);
                    $('input[name="ar_icon"]').val(v.ar_icon);
                    $('input[name="ar_sort"]').val(v.ar_sort);
                    if(v.ar_status == 1){
                        $("input[name=ar_status]:eq(0)").attr("checked",'checked');
                    }else{
                        $("input[name=ar_status]:eq(1)").attr("checked",'checked');
                    }
                }
            })
        })

        //修改操作
        $('#saveAjax').on('submit',function (ev) {

            var name = parent.layer.getFrameIndex(window.name);
            var index = null
            $.ajax({
                type : 'post',
                url : "authSave.html?ar_id="+array.categoryId,
                async : true,
                dataType : 'json',
                data:formData(),
                success : function(e){
                    if(e.code < 0){
                        errorMsg(e.msg)
                    }else{
                        parent.layer.close(name);
                        parent.authAjax()
                    }
                },error:function (xhr) {
                    if(!errorAjax(xhr.status)){
                        return false;
                    }
                },beforeSend:function(){
                    index = layer.msg(title, {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                }
            })

            ev.preventDefault();
        })
    }



    // if(array.categoryId == 0){
    //     console.log('添加权限')
    //     console.log(array)
    // }else{
    //     console.log('修改权限')
    //
    // }


</script>

</body>
</html>