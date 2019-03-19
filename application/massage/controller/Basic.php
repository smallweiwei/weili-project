<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/3/18
 * Time: 15:22
 */

namespace app\massage\controller;
use think\Controller;
use EasyWeChat\Factory;
use think\Db;
use think\facade\Session;
class Basic extends Controller
{
    public $weixin_config;
    public function initialize()
    {
        $wechat = Db::name('config')
            ->where('c_key','weChat')
            ->value('c_value');
        $config = json_decode($wechat,true);
        $this->weixin_config = $config;
        dump(Session::get());
        exit();
        if(!isset($_GET['code'])){
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$config['wc_appid']."&redirect_uri=".$this->get_url()."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            Header("Location: ".$url); // 跳转到微信授权页面 需要用户确认登录的页面
            exit();
        }else{
            $data = $this->GetOpenidFromMp($_GET['code']);
            $data2 = $this->GetUserInfo($data['access_token'],$data['openid']);
            dump($data2);
        }
        exit();
    }

    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        //通过code换取网页授权access_token  和 openid
        $url = $this->__CreateOauthUrlForOpenid($code);
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);//设置超时
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);//运行curl，结果以jason形式返回
        $data = json_decode($res,true);//取出openid access_token
        curl_close($ch);
        return $data;
    }
    
    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->weixin_config['wc_appid'];
        $urlObj["secret"] = $this->weixin_config['wc_appsecret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    /**
     * 获取当前的url 地址
     * @return type
     */
    private function get_url() {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }

    /**
     * 通过access_token openid 从工作平台获取UserInfo
     * @param $access_token
     * @param $openid
     * @return mixed
     */
    public function GetUserInfo($access_token,$openid)
    {
        // 获取用户 信息
        $url = $this->__CreateOauthUrlForUserinfo($access_token,$openid);
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);//设置超时
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);//运行curl，结果以jason形式返回
        $data = json_decode($res,true);//取出openid access_token
        curl_close($ch);

        // 获取看看用户是否关注了 你的微信公众号， 再来判断是否提示用户 关注
//        $access_token2 = $this->get_access_token();
//        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid";
//        $subscribe_info = httpRequest($url,'GET');
//        dump($data);
//        exit();
//        $subscribe_info = json_decode($subscribe_info,true);
//
//        $data['subscribe'] = $subscribe_info['subscribe'];

        return $data;
    }

    /**
     *
     * 构造获取拉取用户信息(需scope为 snsapi_userinfo)的url地址
     * @return 请求的url
     */
    private function __CreateOauthUrlForUserinfo($access_token,$openid)
    {
        $urlObj["access_token"] = $access_token;
        $urlObj["openid"] = $openid;
        $urlObj["lang"] = 'zh_CN';
        $bizString = ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/cgi-bin/user/info?".$bizString;
    }

// 网页授权登录获取 OpendId
    public function GetOpenid()
    {
        dump('123');
        exit;
        if($_SESSION['openid'])
            return $_SESSION['openid'];
        //通过code获得openid

//        if (!isset($_GET['code'])){
//            dump('123');
//            exit();
//            //触发微信返回code码
//            //$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
//            $baseUrl = urlencode($this->get_url());
//            $url = $this->__CreateOauthUrlForCode($baseUrl); // 获取 code地址
//
//            Header("Location: $url"); // 跳转到微信授权页面 需要用户确认登录的页面
//            exit();
//
//        } else {
//            // 上面跳转, 这里跳了回来
//            //获取code码，以获取openid
//            $code = $_GET['code'];
//            $data = $this->getOpenidFromMp($code);
//            $data2 = $this->GetUserInfo($data['access_token'],$data['openid']);
//            $_SESSION['access_token'] = $data['access_token'];
//            $data['nickname'] = $data2['nickname'];
//            $data['sex'] = $data2['sex'];
//            $data['headimgurl'] = $data2['headimgurl'];
//            $data['subscribe'] = $data2['subscribe'];
//            $data['city'] = $data2['city'];// 城市
//            $data['province'] = $data2['province'];//省份
//            $_SESSION['openid'] = $data['openid'];
//
//            return $data;
//        }
    }
}