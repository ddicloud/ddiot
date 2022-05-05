<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 23:43:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-05 15:04:59
 */

namespace admin\controllers\system;

use admin\actions\AdminSettingsAction;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\forms\ClearCache;
use common\widgets\ueditor\UEditorAction;
use Yii;
use yii\filters\VerbFilter;

/**
 * Undocumented class.
 */
class SettingsController extends AController
{
    public $modelClass = '';

    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'them' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @SWG\Post(path="/system/settings/conf",
     *     tags={"系统配置"},
     *     summary="参数设置",
     *     @SWG\Response(
     *         response = 200,
     *         description = "参数设置",
     *     ),
     *     @SWG\Parameter(
     *      in="header",
     *      name="refresh_token",
     *      type="string",
     *      description="刷新token令牌",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="section",
     *      type="string",
     *      enum={"Baidu","Wxapp","Wechat","Wechatpay","Weburl","Sms","Email","Map"},
     *      description="配置类型",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="data",
     *      type="string",
     *      description="配置数据：key=>value",
     *      required=true,
     *    ),
     * )
     */
    public function actionConf()
    {
        global $_GPC;
        $section = $_GPC['section'];
        $data = $_GPC['data'];
        $settings = Yii::$app->settings;
        if (!is_array($data)) {
            return ResultHelper::json(200, 'data数据必须为数组', []);
        }
        foreach ($data as $key => $value) {
            $settings->set($section, $key, $value);
        }

        return ResultHelper::json(200, '设置成功', []);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        parent::actions();

        $setActions = [
            'ueditor' => [
                'class' => UEditorAction::class,
                'config' => [
                    'imageUrlPrefix' => Yii::$app->request->hostInfo, //图片访问路径前缀
                    'imagePathFormat' => '../attachment/image/{yyyy}{mm}{dd}/{time}{rand:6}', //上传保存路径
                    'imageMaxSize' => 10000000,
                    'imageCompressEnable' => true,
                ],
            ],
            'baidu' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                'prepareModel' => 'common\models\Setting',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Baidu::class,
            ],
            'wxapp' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Wxapp::class,
            ],
            'wechat' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Wechat::class,
            ],
            'wechatpay' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Wechatpay::class,
            ],
            'weburl' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                'prepareModel' => 'common\models\Setting',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Weburl::class,
            ],
            'sms' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Sms::class,
            ],
            'email' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Email::class,
            ],
            'map' => [
                'class' => AdminSettingsAction::class,
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Map::class,
            ],
        ];

        return  $setActions;
    }

    /**
     * 清理缓存.
     *
     * @return string
     */
    public function actionClearCache()
    {
        // $this->layout = "@backend/views/layouts/main-base";
        $model = new ClearCache();
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '清理成功');
        }

        $message = ErrorsHelper::getModelError($model);

        return ResultHelper::json(400, $message);
    }

    public function actionSetCache()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('bloc', '');
            if ($data) {
                $key = Yii::$app->user->identity->id.'globalBloc';
                Yii::$app->cache->set($key, $data);

                return ResultHelper::json(200, '切换成功', Yii::$app->cache->get('globalBloc'));
            } else {
                return ResultHelper::json(200, '切换失败', []);
            }
        }
    }

    public function actionStore()
    {
        return $this->render('store');
    }

    public function actionThem()
    {
        global $_GPC;
        $themcolor = $_GPC['themcolor'];

        $this->cache->set('themcolor', $themcolor);

        return ResultHelper::json(200, '主题设置成功', [
            'themcolor' => $_GPC,
            'themcolorCache' => $this->cache->get('themcolor'),
        ]);
    }
}
