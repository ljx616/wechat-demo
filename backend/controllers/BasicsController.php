<?php
/**
 * Created by PhpStorm.
 * User: laravelCode
 * Date: 2018/9/28
 * Time: 12:04
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class BasicsController extends Controller
{
    public function actionAccessToken(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['wechat']['appid'] . "&secret=" . Yii::$app->params['wechat']['appsecret'];

        //初始化一个curl会话
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//如果你的内容不敏感， 暂时 使用curl_exec()之前跳过ssl检查项。
        $result = curl_exec($ch);
//        var_dump(curl_error($ch));
        curl_close($ch);
//        var_dump($result);
        $result = $this->response($result);
        //获取token成功，数据解析
        if ($result['access_token']){
            $access_token = $result['access_token'];

            $cache = Yii::$app->cache;
            $cache->set('access_token',$access_token,7200);
        }else{
            return "access_token获取失败！";
        }

    }


    private function response($text)
    {
        return json_decode($text, true);
    } 











}