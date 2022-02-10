<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-30 01:48:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-24 01:10:30
 */
 
namespace common\filters\auth;


use common\models\enums\CodeStatus;
use Yii;
use yii\filters\auth\HttpBasicAuth as AuthHttpBasicAuth;
use yii\web\UnauthorizedHttpException;

class HttpBasicAuth extends AuthHttpBasicAuth
{

    /**
     * {@inheritdoc}
     */
    public function handleFailure($response)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       
        throw new UnauthorizedHttpException('用户token验证失败',CodeStatus::getValueByName('token失效'));

    }
    

}