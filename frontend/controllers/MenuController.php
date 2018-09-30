<?php
/**
 * Created by PhpStorm.
 * User: laravelCode
 * Date: 2018/9/27
 * Time: 10:44
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class MenuController extends Controller
{

    public function actionIndex()
    {
        return 1;
    }
    public function actionSetMenu(){

        $appid = "wxbb66cd84d793b2de";
        $cache = Yii::$app->cache;
        if ($cache->get($appid)){
            $access_token = $cache->get($appid);
        }else{
            $appsecret = "a380e4af86ca899cd0b969c64fbb4afe";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
            $output = https_request($url);
            $jsoninfo = json_decode($output, true);

            $access_token = $jsoninfo["access_token"];

            $cache->add($appid,$access_token,7200);
        }


        $jsonmenu = '{
            "button":[
            {
                "name":"农机业务",
               "sub_button":[
                {
                   "type":"click",
                   "name":"农机手",
                   "key":"农机手"
                },
                {
                   "type":"click",
                   "name":"种植户",
                   "key":"种植户"
                },
                {
                   "type":"click",
                   "name":"农机主",
                   "key":"农机主"
                }]
            },
            
            {
               "name":"后台管理",
               "sub_button":[
                {
                   "type":"click",
                   "name":"农机后台",
                   "key":"农机后台"
                },
                {
                   "type":"click",
                   "name":"链花后台",
                   "key":"链花后台"
                }]
           
            }
            {
                "type":"view",
                "name":"本地天气",
                "url":"http://m.hao123.com/a/tianqi"
            }]
        }';

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $result = https_request($url, $jsonmenu);
        var_dump($result);

        function https_request($url,$data = null){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }
    }

    public function actionAa(){
        return "daaaa";
    }
}