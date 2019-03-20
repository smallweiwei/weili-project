<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * Users: serena
 * Date: 2019/3/19
 * Time: 11:22
 */

namespace app\massage\controller;
use think\Controller;
use EasyWeChat\Factory;
use think\Db;

class Weixin extends Controller
{
    public $config;
    public function initialize()
    {
        $wechat = Db::name('config')
            ->where('c_key','weChat')
            ->value('c_value');
        $array = json_decode($wechat,true);
        $config = [
            'app_id' =>$array['wc_appid'],
            'secret' => $array['wc_appsecret'],
            'token' => $array['wc_token'],
            'response_type' => 'array',
        ];
        $this->config = $config;
        return parent::initialize();
    }

    public function weixinApi(){
        $app = Factory::officialAccount($this->config);
        $app->server->push(function ($message) {
            return "您好！欢迎关注测试号";
        });
        $buttons = [
            [
                "type"      => "view",
                "name"       => "推拿预约",
                "url"       => "https://massage.buymelots.com/massage.html",
            ],
        ];
        $app->menu->create($buttons);

        $response = $app->server->serve();
        $response->send();

        exit;
    }
}