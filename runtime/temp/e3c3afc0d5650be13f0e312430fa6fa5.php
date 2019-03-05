<?php /*a:2:{s:45:"template\adminView\manager\role_add_view.html";i:1549871821;s:35:"template\adminView\public\head.html";i:1549871821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>微粒后台管理系统 - 添加角色
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

    .permission-list {
        border: solid 1px #eee;
    }
    .permission-list > dt {
        background-color: #F5F5F5;
        padding: 5px 10px;
    }
    .permission-list > dd {
        padding: 10px;
        padding-left: 30px;
    }
    .permission-list > dd > dl {
        border-bottom: 0;
    }
    .permission-list > dd > dl > dt {
        display: inline-block;
        float: left;
        white-space: nowrap;
        width: 100px;
    }
</style>

</head>
<body class="gray-bg">

<div class="col-sm-12" style="padding: 0">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <form method="post" class="form-horizontal addAjax">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="essential">*</span>&nbsp;&nbsp;角色名称</label>
                    <div class="col-sm-10">
                        <input type="text" required="required" class="form-control" name="ag_title">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">描&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;述</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ag_describe">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态</label>
                    <div class="formControls col-sm-10 skin-minimal">
                        <div class="radio-box">
                            <input type="radio" checked id="female" name="ag_status" value="1" />
                            <label for="female">启用</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="male" name="ag_status" value="2" />
                            <label for="male">禁用</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">角色权限</label>
                    <div class="formControls col-sm-10 skin-minimal" id="roleAuth"></div>
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
    var roleDivision = array.roleDivision

    authAjax()
    /**
     * 获取权限列表ajax
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
                    // array = e.data //查询出的数据赋值到array
                    roleorityList(e.data)
                }
            },error:function (xhr) {
                if(!errorAjax(xhr.status)){
                    return false;
                }
            }
        })
    }

    /**
     * 在页面显示权限
     * @param data
     */
    function roleorityList(data){
        var html = '';
        $.each(data,function (key,val) {
            // console.log(val)
            if(!isArrayNull(val.ar_pid)){
                html += '<dl class="permission-list">'
                html += '<dt>'
                html += '<label>'
                html += '<input type="checkbox" value="'+val.ar_id+'" name="ag_rules">'
                html += val.ar_title
                html += '</label>'
                html += '</dt>'
                html += '<dd>'
                html += '<dl class="cl permission-list2">'
                    $.each(val.ar_pid,function (k,v) {
                        html += '<dt>'
                        html += '<label>'
                        html += '<input type="checkbox" value="'+v.ar_id+'" name="ag_rules">'
                        html += v.ar_title
                        html += '</label>'
                        html += '</dt>'
                    })
                html += '</dl>'
                html += '</dd>'
                html += '</dl>'
            }

        })
        $('#roleAuth').html(html)
        // console.log(html)
    }

    var name = parent.layer.getFrameIndex(window.name);
    var index = null

    if(roleDivision == 1){
        $('.addAjax').attr('id','addAjax');
        $('#addAjax').on('submit',function (ev) {
            $.ajax({
                type : 'post',
                url : "roleAdd.html",
                async : true,
                dataType : 'json',
                data:formData(),
                success : function(e){
                    if(e.code < 0){
                        errorMsg(e.msg)
                    }else{
                        parent.layer.close(name);
                        parent.roleAjax()
                    }
                },error:function (xhr) {
                    if(!errorAjax(xhr.status)){
                        return false;
                    }
                },beforeSend:function(){
                    index = layer.msg('角色添加中', {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                }
            })
            ev.preventDefault();
        })
    }else{
        if(isArrayNull(array.roleData)){
            layer.confirm('数据出错，请重新打开？', {
                btn: ['确认','取消'],
                title:'错误信息'
            }, function(){
                parent.layer.close(name);
            }, function(){
                parent.layer.close(name);
            });
        }else{
            $('.addAjax').attr('id','saveAjax');
            var data = array.roleData
            // console.log(data)
            $('input[name="ag_title"]').val(data.ag_title);
            $('input[name="ag_describe"]').val(data.ag_describe);
            if(data.ag_status == 1){
                $('input[name="ag_status"]:eq(0)').attr("checked",'checked');
            }else{
                $('input[name="ag_status"]:eq(1)').attr("checked",'checked');
            }
            var ag_rules = data.ag_rules.split(',')

            var radiovar = document.getElementsByName("ag_rules");
            $.each(radiovar,function (key,v) {
                $.each(ag_rules,function (k,n) {
                    if(n == v.value){
                        radiovar[key].checked = "checked";
                    }
                })
            })
        }
        $('#saveAjax').on('submit',function (ev) {
            $.ajax({
                type : 'post',
                url : "roleSave.html?ag_id="+data.ag_id,
                async : true,
                dataType : 'json',
                data:formData(),
                success : function(e){
                    if(e.code < 0){
                        errorMsg(e.msg)
                    }else{
                        parent.layer.close(name);
                        parent.roleAjax()
                    }
                },error:function (xhr) {
                    if(!errorAjax(xhr.status)){
                        return false;
                    }
                },beforeSend:function(){
                    index = layer.msg('角色修改中。。。', {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                }
            })
            ev.preventDefault();
        })
    }



</script>

</body>
</html>