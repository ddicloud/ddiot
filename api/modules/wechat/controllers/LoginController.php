<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-05 08:26:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-07 10:03:07
 */

namespace api\modules\wechat\controllers;

use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

/**
 * login controller for the `WeChat` module
 */
class LoginController extends AController
{

    public function actionIndex(): array
    {
        if (Yii::$app->wechat->isWechat && !Yii::$app->wechat->isAuthorized()) {
            return Yii::$app->wechat->authorizeRequired()->send();
        }

        // 获取微信当前用户信息方法一
        Yii::$app->session->get('wechatUser');

        // 获取微信当前用户信息方法二
        Yii::$app->wechat->user;
        return ResultHelper::json(200,'获取成功');
    }
}
