<?php
/**
 * Created by PhpStorm.
 * User: laravelCode
 * Date: 2018/9/30
 * Time: 14:24
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use EasyWeChat\Factory;

class ServerController extends Controller
{

    public function actionIndex(){
        $config = [
            'app_id' => 'wx3cf0f39249eb0xxx',
            'secret' => 'f1c242f4f28f735d4687abb469072xxx',
            'token' => 'TestToken',
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        $app = Factory::officialAccount($config);
        $app->server->push(function ($message) {
            return "您好！欢迎使用 EasyWeChat!";
        });

        $response = $app->server->serve();

// 将响应输出
        $response->send();
    }


}