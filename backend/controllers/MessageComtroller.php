<?php
/**
 * Created by PhpStorm.
 * User: laravelCode
 * Date: 2018/9/28
 * Time: 17:12
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class MessageComtroller extends Controller
{
    public function actionToUser(){
        $url = "";
        $userid = "";
        $content = "";
        $jsonmenu = '{
            "touser": "", 
                "msgtype": "text", 
                "text": {
                    "content": ""
            }
        }';
        //初始化一个curl会话
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//如果你的内容不敏感， 暂时 使用curl_exec()之前跳过ssl检查项。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonmenu);
        $result = curl_exec($ch);
//        var_dump(curl_error($ch));
        curl_close($ch);
    }
}