<?php /*a:1:{s:35:"template/adminView/login/index.html";i:1557933895;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>后台管理</title>
    <link href="/static/adminView/css/admin-login.css" rel="stylesheet" type="text/css" />
    <!--<script type="text/javascript" src="/static/adminView/plugins/jq/jquery-3.3.1.min.js"></script>-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.staticfile.org/angular.js/1.4.6/angular.min.js"></script>

</head>

<body>
<div class="login_box">
    <div class="login_l_img">
        <img src="/static/adminView/images/admin-login-img.png">
    </div>
    <div class="login">
        <div class="login_logo"><img src="/static/adminView/images/admin-login_logo.png" /></div>
        <div class="login_name">
            <p>后台管理系统</p>
        </div>
        <div id="admin-login">
            <form method="post" class="form-horizontal" id="addAjax">
                <div class="user">
                    <input type="text" required="required" oninvalid="setCustomValidity('管理名称不能为空')"
                           name="m_name" placeholder="管理员名称" autocomplete="off" oninput="setCustomValidity('')">
                </div>
                <div class="user">
                    <input type="password" required="required" oninvalid="setCustomValidity('密码不能为空')"
                           name="m_password" placeholder="管理员密码" autocomplete="off" oninput="setCustomValidity('')">
                </div>
<!--                <div class="user">-->
<!--                    <input type="text" required="required" oninvalid="setCustomValidity('验证码不能为空')"-->
<!--                           name="idCode" placeholder="验证码" autocomplete="off" oninput="setCustomValidity('')">-->
<!--                </div>-->
                <input value="登录" style="width:100%;" type="submit">
            </form>
        </div>

    </div>
    <div class="copyright"  ng-app="myAg" ng-controller="myCompany" >{{company}} 版权所有©2018-2019 技术支持电话：020-34353633</div>
</div>


<script type="text/javascript" src="/static/adminView/js/config.js"></script>
<script type="text/javascript" src="/static/adminView/js/function.js"></script>
<script type="text/javascript" src="/static/adminView/js/plugins/layer/layer.js"></script>
<script type="text/javascript" src="/static/adminView/js/plugins/layer/layer.js"></script>
<script type="text/javascript">
    var app = angular.module('myAg', []);
    app.controller('myCompany', function($scope) {
        $scope.company = company;
    });
    var num = 0
    $('#addAjax').on('submit',function (ev) {
        if(getCookie('errorNum') >= 5){
            errorMsg('登录不正常过多，请1小时后重试')
        }else{

            $.ajax({
                type : 'post',
                url : "api_login.html",
                async : true,
                dataType : 'json',
                data:formData(),
                success : function(e){
                    if(e.code < 0){
                        num += 1
                        // setCookie('errorNum',num,60*60*1)//保存1小时
                        errorMsg(e.msg)
                    }else{
                        window.location.replace(admin_url);
                    }
                },error:function (xhr) {
                    if (!errorAjax(xhr.status)) {
                        return false;
                    }
                },beforeSend:function(){
                    index = layer.msg('登录提交中', {
                        icon: 16,
                        shade: 0.4,
                        time:false //取消自动关闭
                    });
                    // return false;
                },
            })
        }

        ev.preventDefault();
    })





</script>

</body>
</html>
