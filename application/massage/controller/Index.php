<?php
namespace app\massage\controller;
use EasyWeChat\Factory;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $config = [
            'app_id' => 'wx71b7ea381e6958e6',
            'secret' => '3c0ff09f2653ea0a4817e90cd1c9b84c',
            'response_type' => 'array',
        ];

        $app = Factory::officialAccount($config);
        dump($app);
//        $buttons = [
//            [
//                "type" => "click",
//                "name" => "今日歌曲",
//                "key"  => "V1001_TODAY_MUSIC"
//            ],
//            [
//                "name"       => "菜单",
//                "sub_button" => [
//                    [
//                        "type" => "view",
//                        "name" => "搜索",
//                        "url"  => "http://www.soso.com/"
//                    ],
//                    [
//                        "type" => "view",
//                        "name" => "视频",
//                        "url"  => "http://v.qq.com/"
//                    ],
//                    [
//                        "type" => "click",
//                        "name" => "赞一下我们",
//                        "key" => "V1001_GOOD"
//                    ],
//                ],
//            ],
//        ];
//        $app->menu->create($buttons);
//        $app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。");
        return $this->fetch();
    }

    public function weixin(){
        dump('123123');
        dump(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger'));
        exit;
    }
}
