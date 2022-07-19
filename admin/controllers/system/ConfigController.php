<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 16:23:11
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-18 16:30:32
 */

namespace admin\controllers\system;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use diandi\addons\models\Bloc;
use diandi\addons\models\form\App;
use diandi\addons\models\form\Api;
use common\models\forms\Weburl;
use diandi\addons\models\form\Baidu;
use diandi\addons\models\form\Email;
use diandi\addons\models\form\Map;
use diandi\addons\models\form\Microapp;
use diandi\addons\models\form\Oss;
use diandi\addons\models\form\Sms;
use diandi\addons\models\form\Wechat;
use diandi\addons\models\form\Wechatpay;
use diandi\addons\models\form\Wxapp;
use Yii;

/**
 * Description of RuleController.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class ConfigController extends AController
{
    public $modelClass = '';

    public function actions()
    {
        global $_GPC;
        $bloc_id = $_GPC['bloc_id'];
        $bloc = Bloc::findOne($bloc_id);
    }

    /**
     * @SWG\Post(path="/system/config/Weburl",
     *     tags={"系统配置"},
     *     summary="域名",
     *     @SWG\Response(
     *         response = 200,
     *         description = "域名",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="query",
     *     name="Baidu",
     *     type="string",
     *     description="Baidu",
     *     required=true,
     *   )
     * )
     */
    public function actionWeburl()
    {
        global $_GPC;
        $settings = Yii::$app->settings;
        $model = new Weburl();
        $bloc_id = $_GPC['bloc_id'];
        if (Yii::$app->request->isPost) {
            $Weburl = $_GPC['Weburl'];
            foreach ($Weburl as $key => $value) {
                $settings->set('Weburl', $key, $value);
            }
            return ResultHelper::json(200, '保存成功', []);
        } else {
            $set = $settings->getAllBySection('Weburl');

            return ResultHelper::json(200, '获取成功', $set);
        }
    }


    /**
     * @SWG\Post(path="/system/config/baidu",
     *     tags={"系统配置"},
     *     summary="百度",
     *     @SWG\Response(
     *         response = 200,
     *         description = "参数设置",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="query",
     *     name="Baidu",
     *     type="string",
     *     description="Baidu",
     *     required=true,
     *   )
     * )
     */
    public function actionBaidu()
    {
        global $_GPC;
        $model = new Baidu();
        $bloc_id = $_GPC['bloc_id'];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/wechatpay",
     *     tags={"系统配置"},
     *     summary="微信支付",
     *     @SWG\Response(
     *         response = 200,
     *         description = "微信支付",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Wechatpay",
     *     type="string",
     *     description="Wechatpay",
     *     required=true,
     *   )
     * )
     */
    public function actionWechatpay()
    {
        global $_GPC;

        $model = new Wechatpay();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/sms",
     *     tags={"系统配置"},
     *     summary="短信",
     *     @SWG\Response(
     *         response = 200,
     *         description = "短信",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Sms",
     *     type="string",
     *     description="Sms",
     *     required=true,
     *   )
     * )
     */
    public function actionSms()
    {
        global $_GPC;

        $model = new Sms();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/email",
     *     tags={"系统配置"},
     *     summary="邮箱",
     *     @SWG\Response(
     *         response = 200,
     *         description = "邮箱",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Email",
     *     type="string",
     *     description="Email",
     *     required=true,
     *   )
     * )
     */
    public function actionEmail()
    {
        global $_GPC;

        $model = new Email();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/wxapp",
     *     tags={"系统配置"},
     *     summary="小程序",
     *     @SWG\Response(
     *         response = 200,
     *         description = "小程序",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Wxapp",
     *     type="string",
     *     description="Wxapp",
     *     required=true,
     *   )
     * )
     */
    public function actionWxapp()
    {
        global $_GPC;

        $model = new Wxapp();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/wechat",
     *     tags={"系统配置"},
     *     summary="公众号",
     *     @SWG\Response(
     *         response = 200,
     *         description = "公众号",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Wechat",
     *     type="string",
     *     description="Wechat",
     *     required=true,
     *   )
     * )
     */
    public function actionWechat()
    {
        global $_GPC;

        $model = new Wechat();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/microapp",
     *     tags={"系统配置"},
     *     summary="抖音小程序",
     *     @SWG\Response(
     *         response = 200,
     *         description = "抖音小程序",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Microapp",
     *     type="string",
     *     description="Microapp",
     *     required=true,
     *   )
     * )
     */
    public function actionMicroapp()
    {
        global $_GPC;

        $model = new Microapp();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/app",
     *     tags={"系统配置"},
     *     summary="app",
     *     @SWG\Response(
     *         response = 200,
     *         description = "app",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="App",
     *     type="string",
     *     description="App",
     *     required=true,
     *   )
     * )
     */
    public function actionApp()
    {
        global $_GPC;

        $model = new App();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/map",
     *     tags={"系统配置"},
     *     summary="地图",
     *     @SWG\Response(
     *         response = 200,
     *         description = "地图",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Map",
     *     type="string",
     *     description="Map",
     *     required=true,
     *   )
     * )
     */
    public function actionMap()
    {
        global $_GPC;

        $model = new Map();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/oss",
     *     tags={"系统配置"},
     *     summary="对象存储",
     *     @SWG\Response(
     *         response = 200,
     *         description = "对象存储",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="Oss",
     *     type="string",
     *     description="Oss",
     *     required=true,
     *   )
     * )
     */
    public function actionOss()
    {
        global $_GPC;
        $model = new Oss();
        $bloc_id =  $_GPC['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }

    /**
     * @SWG\Post(path="/system/config/api",
     *     tags={"系统配置"},
     *     summary="api",
     *     @SWG\Response(response = 200, description = "api"),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(in="formData", name="app_id", type="string", description="APP ID", required=true)
     *     @SWG\Parameter(in="formData", name="app_secret", type="string", description="APP SECRET", required=true)
     * )
     */
    public function actionApi()
    {
        global $_GPC;
        $model = new Api();
        $bloc_id =  $_GPC['bloc_id'];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), '');
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], []);
            } else {
                return ResultHelper::json(400, $Res['message'], []);
            }
        } else {
            $model->getConf($bloc_id);
            return ResultHelper::json(200, '获取成功', $model);
        }
    }
}
