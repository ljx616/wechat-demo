<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{



    public function  actionIndex(){

    }


    public function actionMenu()
    {
//        return 1;
        $cache = Yii::$app->cache;
        if ($cache->get('access_token')) {
//            return 1;
        } else {

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['wechat']['appid'] . "&secret=" . Yii::$app->params['wechat']['appsecret'];

            //初始化一个curl会话
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//如果你的内容不敏感， 暂时 使用curl_exec()之前跳过ssl检查项。
            $result = curl_exec($ch);
            var_dump(curl_error($ch));
            curl_close($ch);
var_dump($result);
            $result = $this->response($result);
            //获取token成功，数据解析
            $access_token = $result['access_token'];

            $cache->set('access_token',$access_token,7200);
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

    private function response($text)
    {
        return json_decode($text, true);
    }

}
