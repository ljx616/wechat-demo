<?php
/**
 * Created by PhpStorm.
 * User: laravelCode
 * Date: 2018/9/27
 * Time: 10:44
 */

namespace backend\controllers;

use Yii;
use yii\redis\Cache;
use yii\web\Controller;

class MenuController extends BasicsController
{


    public function actionIndex()
    {
        return 1;
    }

    private function response($text)
    {
        return json_decode($text, true);
    }

    public function actionSetMenu(){
        $cache = Yii::$app->cache;
        if (!$cache->get('access_token')){
            Yii::$app->runAction('basics/access-token');
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
           
            },
            
            {
                "type":"view",
                "name":"本地天气",
                "url":"http://m.hao123.com/a/tianqi"
            }]
        }';

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $cache->get('access_token');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        //如果内容不敏感， 暂时 使用curl_exec()之前跳过ssl检查项。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonmenu);
        $result = curl_exec($ch);
//        var_dump($result);
        curl_close($ch);

        $result = $this->response($result);
        if ($result['errcode'] == '0' && $result['errmsg'] == 'ok' ){
            return "设置成功";
        }else{
            var_dump($result);
            return "设置失败";
        }
    }

    public function actionShowMenu(){
        $cache = Yii::$app->cache;
        if (!$cache->get('access_token')){
            Yii::$app->runAction('basics/access-token');
        }

        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $cache->get('access_token');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        //如果内容不敏感， 暂时 使用curl_exec()之前跳过ssl检查项。

        $result = curl_exec($ch);

        curl_close($ch);
        echo '<pre>';
//        var_dump($cache->get('access_token'));
        var_dump($result);
        echo '</pre>';

    }

    public function actionDelMenu(){
        $cache = Yii::$app->cache;
        if (!$cache->get('access_token')){
            Yii::$app->runAction('basics/access-token');
        }

        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $cache->get('access_token');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        //如果内容不敏感， 暂时 使用curl_exec()之前跳过ssl检查项。

        $result = curl_exec($ch);

        curl_close($ch);
        echo '<pre>';
//        var_dump($cache->get('access_token'));
        var_dump($result);
        echo '</pre>';
    }




}