<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 20:38:06
 */

namespace admin\controllers;

use admin\models\User;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\UrlHelper;
use EasyWeChat\Factory;
use Yii;

class WechatController extends AController
{
    public $modelClass = '';
    protected array $authOptional = ['signup'];
    public int $searchLevel = 0;

    public function actionAuthUrl(): array
   {
        $configPath = Yii::getAlias('@common/config/wechat.php');
        $config = [];
        if (file_exists($configPath)) {
            $config = require_once $configPath;
        }
        $data = [
            'app_id' => $config['app_id'],
            'secret' => $config['secret'],
            'token' => $config['token'],
            'aes_key' => $config['aes_key'],
        ];

        $openPlatform = Factory::openPlatform($data);

        $callback = UrlHelper::adminUrl('wechat', 'signup', [
            'bloc_id' =>\Yii::$app->request->input('bloc_id',0),
            'store_id' =>\Yii::$app->request->input('store_id',0),
        ]);

        $url = $openPlatform->getPreAuthorizationUrl($callback); // 传入回调URI即可

        return ResultHelper::json(200, '获取成功', ['url' => $url]);
    }

    public function actionSignup(): array
    {
        $code = Yii::$app->request->post('code');
        if ($code) {
            $configPath = Yii::getAlias('@common/config/wechat.php');
            $config = [];
            if (file_exists($configPath)) {
                $config = require_once $configPath;
            }
            try {
                Yii::$app->params['wechatConfig'] = $config;
                $app = Yii::$app->wechat->app;
                $oauth = $app->oauth;
                $user = $oauth->user();
            } catch (\Exception $e) {
                return ResultHelper::json(400, $e->getMessage());
            }
            if ($user->id) {
                $adminUser = User::find()->where(['open_id' => $user->id])->one();
                if ($adminUser) {
                    $service = Yii::$app->service;
                    $service->namespace = 'admin';
                    $userinfo = $service->AccessTokenService->getAccessToken($adminUser, 1);

                    return ResultHelper::json(200, '登录成功！', $userinfo);
                } else {
                    $adminUser = new User();
                    $maxId = User::find()->max('id');
                    $adminUser->open_id = $user->id;
                    $adminUser->union_id = $user->getOriginal()['unionid'] ?? null;
                    $res = $adminUser->signup($maxId + 1, $maxId + 1, ($maxId + 1).'@cn.com', '123465', 1);

                    return ResultHelper::json(200, '注册成功', (array)$res);
                }
            } else {
                ResultHelper::json(400, '获取微信用户失败！');
            }
        } else {
            ResultHelper::json(400, 'CODE 是必须的！');
        }
        return ResultHelper::json(200, '注册成功');

    }

    public function actionTick(): void
   {
       $data = Yii::$app->request->input();
        loggingHelper::writeLog('WechatController', 'tick', '服务器消息处理', $data);
    }

    public function actionBind(): array
    {
        $code = Yii::$app->request->post('code');
        if ($code) {
            $configPath = Yii::getAlias('@common/config/wechat.php');
            $config = [];
            if (file_exists($configPath)) {
                $config = require_once $configPath;
            }
            try {
                Yii::$app->params['wechatConfig'] = $config;
                $app = Yii::$app->wechat->app;
                $oauth = $app->oauth;
                $user = $oauth->user();
            } catch (\Exception $e) {
                return ResultHelper::json(400, $e->getMessage());
            }
            if ($user->id) {
                $adminUser = User::find()->where(['open_id' => $user->id])->one();
                if ($adminUser) {
                    return ResultHelper::json(400, '当前微信已绑定用户！');
                } else {
                    $adminUser = User::find()->where(['id' => Yii::$app->user->identity->user_id])->one();
                    if ($adminUser) {
                        $adminUser->open_id = $user->id;
                        $adminUser->union_id = $user->getOriginal()['unionid'] ?? null;
                        if ($adminUser->save(false)) {
                            return ResultHelper::json(200, '绑定成功！');
                        }
                    }
                    ResultHelper::json(400, '绑定失败！');
                }
            } else {
                ResultHelper::json(400, '获取微信用户失败！');
            }
        } else {
            ResultHelper::json(400, 'CODE 是必须的！');
        }
        return ResultHelper::json(200, '绑定成功！');

    }

    public function actionUnbind(): array
    {
        $adminUser = User::find()->where(['id' => Yii::$app->user->identity->user_id])->one();
        if ($adminUser) {
            $adminUser->open_id = null;
            $adminUser->union_id = null;
            if ($adminUser->save(false)) {
                return ResultHelper::json(200, '解除绑定成功！');
            } else {
                return ResultHelper::json(400, '解除绑定失败！');
            }
        } else {
            return ResultHelper::json(400, '无效的用户信息！');
        }
    }
}
