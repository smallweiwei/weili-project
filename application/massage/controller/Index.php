<?php
namespace app\massage\controller;
use EasyWeChat\Factory;

class Index
{
    public function index()
    {
        $config = [
            'app_id' => 'wx71b7ea381e6958e6',
            'secret' => '3c0ff09f2653ea0a4817e90cd1c9b84c',
        ];

        $app = Factory::officialAccount($config);
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        $app->menu->create($buttons);
        $app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。");
    }
}
