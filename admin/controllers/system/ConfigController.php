<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 16:23:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-27 21:46:51
 */

namespace admin\controllers\system;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\models\forms\Weburl;
use diandi\addons\models\Bloc;
use diandi\addons\models\form\Api;
use diandi\addons\models\form\App;
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

    public int $searchLevel = 0;

    public function actions(): array
    {
        global $_GPC;
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        Bloc::findOne($bloc_id);
        return parent::actions();
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
    public function actionWeburl(): array
    {
        global $_GPC;
        $settings = Yii::$app->settings;
        $model = new Weburl();
        if (Yii::$app->request->isPost) {
            $Weburl =\Yii::$app->request->input('Weburl');
            foreach ($Weburl as $key => $value) {
                $settings->set('Weburl', $key, $value);
            }

            return ResultHelper::json(200, '保存成功', $model->toArray());
        } else {
            $set = $settings->getAllBySection('Weburl');

            return ResultHelper::json(200, '获取成功', $set);
        }
    }


    public function actionBaidu(): array
    {
        global $_GPC;
        $model = new Baidu();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Baidu')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }



    public function actionWechatpay(): array
    {
        global $_GPC;

        $model = new Wechatpay();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Wechatpay')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionSms(): array
    {
        global $_GPC;

        $model = new Sms();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Sms')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }



    public function actionEmail(): array
    {
        global $_GPC;

        $model = new Email();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Email')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionWxapp(): array
    {
        global $_GPC;

        $model = new Wxapp();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Wxapp')['bloc_id'];
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionWechat(): array
    {
        global $_GPC;

        $model = new Wechat();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Wechat')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionMicroapp(): array
    {
        global $_GPC;

        $model = new Microapp();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Microapp')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionApp(): array
    {
        global $_GPC;

        $model = new App();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('App')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionMap(): array
    {
        global $_GPC;

        $model = new Map();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Map')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'],$Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionOss(): array
    {
        global $_GPC;
        $model = new Oss();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Oss')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }


    public function actionApi(): array
    {
        global $_GPC;
        $model = new Api();

        if (Yii::$app->request->isPost) {
            $bloc_id =\Yii::$app->request->input('Api')['bloc_id'];

            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                return ResultHelper::json(200, $Res['message'], $Res);
            } else {
                return ResultHelper::json(400, $Res['message']);
            }
        } else {
            $bloc_id =\Yii::$app->request->input('bloc_id',0);

            $model->getConf($bloc_id);

            return ResultHelper::json(200, '获取成功', $model->toArray());
        }
    }
}
