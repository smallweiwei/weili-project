/**
 * 前端自定义函数库
 */

//权限勾选效果
$(function(){
    $(".permission-list dt input:checkbox").click(function(){
        $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
    });
    $(".permission-list2 dt input:checkbox").click(function(){
        var l2=$(this).parents(".permission-list").find(".permission-list2 dt").find("input:checked").length;
        if(l2==0){
            $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
        }else{
            $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
        }
    });

    // console.log(img)
});

/**
 * 判断string是否为空
 * @param n 输入的值
 * @returns {boolean}
 */
function isInputNull(n)
{
    if(!n){
        return false;
    }else{
        return true;
    }
}

/**
 * 判断数组是否为空
 * @param array 数组
 * @returns {boolean} true / false
 */
function isArrayNull(array)
{
    if(array == false){
        return true
    }else{
        return false
    }
}

//判断数值是否为空
function isUndefined(value)
{
    return value==undefined || $.trim(value).length==0;
}

/**
 * 弹出错误信息
 * @param data 错误类型
 */
function errorMsg(data)
{
    layer.msg(data,{time: 2000, icon:5},function(){
        return true
    });
}


/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
function layerShow(title,url,w,h)
{
    if (title == null || title == '') {
        title=false;
    };
    if (url == null || url == '') {
        url="404.html";
    };
    if (w == null || w == '') {
        w=800;
    };
    if (h == null || h == '') {
        h=($(window).height() - 50);
    };
    layer.open({
        type: 2,
        area: [w+'px', h +'px'],
        fix: false, //不固定
        maxmin: true,
        shade:0.4,
        title: title,
        content: url
    });
}

/**
 * 获取表单提交的数据
 */
function formData()
{
    var d = {};
    var t = $('form').serializeArray();
    var fields = $(":checkbox").serializeArray();//获取多选
    var data = new Array();
    var data_key = ''

    //把多选的值封装成新数组
    $.each(fields,function () {
        data.push(this.value)
        data_key = this.name
    })

    let select = $("#massage_time option:selected");
    $.each(select,function () {
        data.push(this.value)
        data_key = 'ms_workShift'
    })

    $.each(t, function () {
        if(this.name == data_key){
            d[data_key] = data.join(',')
        }else{
            d[this.name] = strReplace(this.value);
        }
    });
    return d
}


/**
 * 去除二边空格
 * @param str 字符串
 * @returns {string | * | void}
 */
function strReplace(str)
{
    return str.replace(/^\s+|\s+$/g,"")
}

/**
 * ajax返回错误信息
 * @param data Status Code 响应码
 * @returns {boolean} 返回true  false
 */
function errorAjax(data)
{
    if(data == '404'){
        layer.msg('服务器异常',{time: 2000, icon:5});
        return false;
    }else if(data == '500'){
        layer.msg('服务器异常',{time: 2000, icon:5});
        return false;
    }else if(data != '200'){
        layer.msg('数据提交失败',{time: 2000, icon:5});
        return false;
    }else{
        return true;
    }
}

/**
 * 写入cookie
 * @param c_name cookie名称
 * @param value  cookie值
 * @param expiredays 过期时间
 */
function setCookie(c_name,value,expiredays)
{
    var exdate=new Date()
    exdate.setDate(exdate.getDate()+expiredays)
    document.cookie=`${c_name}=${escape(value)}${(expiredays == null) ? "" : ";expires=" + exdate.toGMTString()}`
}

/**
 *  获取cookie
 * @param c_name cookie名称
 * @returns {*}
 */
function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=")
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1
            c_end=document.cookie.indexOf(";",c_start)
            if (c_end==-1) c_end=document.cookie.length
            return unescape(document.cookie.substring(c_start,c_end))
        }
    }
    return "0"
}

/**
 * 删除cookie
 * @param name
 */
function delCookie(name)
{
    setCookie(name,'','-1')
}

/**
 * 获取后台登录的管理员id
 * @returns {string} 返回管理员id
 */
function getAdminID()
{
    var id = '';
    $.ajax({
        type : 'get',
        url : "api_admin_id.html",
        async : false,
        dataType : 'json',
        success : function(e){
            id = e
        }
    })
    return id
}

/**
 * 时间戳转换成时间
 * @param time 时间戳
 * @returns {string} 返回时间 年-月-日
 */
function getLocalTime(time)
{
    let t = new Date(parseInt(time));
    return t.getFullYear() + "-" +((t.getMonth()+1)<10?"0":"")+(t.getMonth()+1)+"-"+(t.getDate()<10?"0":"")+ (t.getDate());
}

//时间戳转时间，转成年月日 时:分的形式
function getTime(now)
{
    var d=new Date(now*1000);
    var year=d.getFullYear();
    let month
    if((d.getMonth()+1)<10){
        month = '0'+ (d.getMonth()+1);  //补齐
    }else{
        month = d.getMonth()+1
    }
    let date
    if(d.getDate() < 10){
        date = '0'+ d.getDate();  //补齐
    }else{
        date = d.getDate()
    }
    let hour
    if(d.getHours() < 10){
        hour = '0'+ d.getHours();  //补齐
    }else{
        hour = d.getHours();
    }

    let minute
    if(d.getMinutes() < 10){
        minute = '0'+ d.getMinutes();  //补齐
    }else{
        minute = d.getMinutes()
    }

    return year+"年"+month+"月"+date+"日 "+hour+":"+minute;
}


/**
 * 手机号码正则验证
 * @param data 手机号码
 * @returns {boolean}
 */
function isPhone(data)
{
    var phone = /^[1][3,4,5,7,8][0-9]{9}$/;
    if (!phone.test(data)) {
        return false;
    } else {
        return true;
    }
}

/**
 * 获取相对路径
 * @returns {string}
 * @constructor
 */
function GetUrlRelativePath()
{
    var url = document.location.toString();
    var arrUrl = url.split("//");

    var start = arrUrl[1].indexOf("/");
    var relUrl = arrUrl[1].substring(start+1);//stop省略，截取从start开始到结尾的所有字符
    if(relUrl.indexOf("?") != -1){
        relUrl = relUrl.split("?")[0];
    }
    return relUrl;
}

//paraName 等找参数的名称
function GetUrlParam(paraName) {
    var url = document.location.toString();
    var arrObj = url.split("?");

    if (arrObj.length > 1) {
        var arrPara = arrObj[1].split("&");
        var arr;

        for (var i = 0; i < arrPara.length; i++) {
            arr = arrPara[i].split("=");

            if (arr != null && arr[0] == paraName) {
                return arr[1];
            }
        }
        return "";
    }
    else {
        return "";
    }
}

/**
 * 退出登录
 */
function logout()
{
    window.localStorage.removeItem('adminMenu');
    delCookie('admin')
    window.location.href="logout.html";
}

//判断是不是数组，是返回true 否返回false
function isArray(data)
{
    return $.isArray(data)
}

/**
 * 图片全屏放大
 */
function imageEnlarge() {
    const img = document.getElementsByTagName("img")
    let html = '<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">'
    html += '<div id="innerdiv" style="position:absolute;">'
    html += '<img id="bigimg" style="border:5px solid #fff;" src="" />'
    html += '</div>'
    html += '</div>'
    $("body").append(html)
    $.each(img,function (key,value) {
        img[key].onclick = function () {
            var _this = $(this);//将当前的pimg元素作为_this传入函数
            imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
        }
    })
}

/**
 * 点击图片变大方法，再点击关闭
 * @param outerdiv
 * @param innerdiv
 * @param bigimg
 * @param _this
 */
function imgShow(outerdiv, innerdiv, bigimg, _this){
    var src = _this.attr("src");//获取当前点击的pimg元素中的src属性
    $(bigimg).attr("src", src);//设置#bigimg元素的src属性
    /*获取当前点击图片的真实大小，并显示弹出层及大图*/
        const windowW = $(window).width();//获取当前窗口宽度
        const windowH = $(window).height();//获取当前窗口高度
        const realWidth = _this[0].naturalWidth;//获取图片真实宽度
        const realHeight = _this[0].naturalHeight;//获取图片真实高度

        let imgWidth, imgHeight;
        const scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

        if(realHeight>windowH*scale) {//判断图片高度
            imgHeight = windowH*scale;//如大于窗口高度，图片高度进行缩放
            imgWidth = imgHeight/realHeight*realWidth;//等比例缩放宽度
            if(imgWidth>windowW*scale) {//如宽度扔大于窗口宽度
                imgWidth = windowW*scale;//再对宽度进行缩放
            }
        } else if(realWidth>windowW*scale) {//如图片高度合适，判断图片宽度
            imgWidth = windowW*scale;//如大于窗口宽度，图片宽度进行缩放
            imgHeight = imgWidth/realWidth*realHeight;//等比例缩放高度
        } else {//如果图片真实高度和宽度都符合要求，高宽不变
            imgWidth = realWidth;
            imgHeight = realHeight;
        }
        $(bigimg).css("width",imgWidth);//以最终的宽度对图片缩放
        let w = (windowW-imgWidth)/2;//计算图片与窗口左边距
        let h = (windowH-imgHeight)/2;//计算图片与窗口上边距
        $(innerdiv).css({"top":h, "left":w});//设置#innerdiv的top和left属性
        $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg

        $(outerdiv).click(function(){//再次点击淡出消失弹出层
            $(this).fadeOut("fast");
        });
}

//数据存储在SessionStorag
function setSessionStorage(key,value)
{
    if(!window.sessionStorage){
        alert('您的浏览器不支持H5缓存数据特性！');
    }else {
        let session = window.sessionStorage;
        // 存储
        session.setItem(key , value);
        console.log(session);
        //取数据  ==> 因为是已字符串的方式存储的 所以要使用 JSON.parse的方法将字符串转格式
        // JSON.parse() => 字符串转数组或对象的方法
        // JSON.stringify() => 数组或对象转字符串的方法
        console.log(session.getItem(key))
    }
}

function getSessionStorage(key)
{
    if(!window.sessionStorage){
        errorMsg('您的浏览器不支持H5缓存数据特性');
    }else {
        let session = window.sessionStorage;
        return session.getItem(key)
    }
}
