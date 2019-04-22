<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/18
 * Time: 15:22
 */

namespace app\massage\controller;
use app\massage\model\Users;
use think\Controller;
use think\Db;
use think\facade\Cookie;
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

        // 判断是否是微信浏览器
        if(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
            //判断有没有此用户，无，写进数据库，有直接拿出
            if(!Session::get('u_openid')){
                //授权获取openid
                $wxuser = $this->GetOpenid();
                //微信自动登录
                $data = array(
                    'u_openid'=>$wxuser['openid'],//微信openid
                    'u_oauth'=>'weixin',//第三方来源
                    'u_nickname'=>preg_replace('/[\x{10000}-\x{10FFFF}]/u', '',$wxuser['nickname']),//微信昵称
                    'u_sex'=>$wxuser['sex'],//性别
                    'u_head_pic'=>$wxuser['headimgurl'],//头像
                    'u_city' =>$wxuser['city'], //市区
                    'u_province' =>$wxuser['province'], //省份
                    'u_country' =>$wxuser['country'], // 国家
                );
                $user = new Users();
                $list = $user->thirdLogin($data);
//                Cookie::set('u_mobile',$list['u_mobile']);
//                Cookie::set('u_data',$list);
                Cookie::set('u_user_id',$list);//用户id

            }
            $user = new Users();
            $list = $user->thirdLogin(array('u_openid'=>Session::get('u_openid')));
            Cookie::set('u_mobile',$list['u_mobile']);
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取微信用户信息
     * @return mixed 返回用户信息
     */
    private function GetOpenid(){
        //判断有无code，无请求获取code，有，获取access_token

        if(Session::get('u_openid')){
            return Session::get('u_openid');
        }

        if(!isset($_GET['code'])){
            $url = $this->GetOauthCode(urlencode(get_url()));
            Header("Location:".$url); // 跳转到微信授权页面 需要用户确认登录的页面
            exit();
        }else{
            $data = $this->GetAccessToken($_GET['code']);
            $userInfo = $this->GetUserinfo($data['access_token'],$data['openid']);
            Session::set('u_openid',$data['openid']);
            return $userInfo;
        }
    }

    /**
     * 请求获取code
     * @param $url 请求地址
     * @return string 返回授权地址
     */
    private function GetOauthCode($url){
        $urlObj["appid"] = $this->weixin_config['wc_appid'];
        $urlObj["redirect_uri"] = $url;
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_userinfo";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     * 获取access_token和openid
     * @param $code  获取的code
     * @return mixed 返回access_token和openid
     */
    private function GetAccessToken($code){
        $urlObj["appid"] = $this->weixin_config['wc_appid'];
        $urlObj["secret"] = $this->weixin_config['wc_appsecret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = ToUrlParams($urlObj);
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;

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
//        Session::set('access_token',$data['access_token']);
//        Session::set('openid',$data['openid']);
       return $data;
    }

    /**
     * 根据 access_token 和 openid 获取用户信息
     * @param $access_token 获取的access_token
     * @param $openid  获取的openid
     * @return mixed 返回用户基本信息
     */
    private function GetUserinfo($access_token,$openid){
        $array['access_token'] = $access_token;
        $array['openid'] = $openid;
        $array['lang'] = 'zh_CN';
        $url = "https://api.weixin.qq.com/sns/userinfo?".ToUrlParams($array);
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

}