<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 23:43:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-12 10:34:06
 */

namespace admin\controllers\system;

use admin\actions\AdminSettingsAction;
use admin\controllers\AController;
use common\components\ueditor\UEditorAction;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\forms\ClearCache;
use Yii;

/**
 * Undocumented class.
 */
class SettingsController extends AController
{
    public $modelClass = '';

    public $enableCsrfValidation = false;

    public int $searchLevel = 0;


    public function actionConf(): array
    {
        $section = \Yii::$app->request->input('section');
        $data = \Yii::$app->request->input('data');
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
    public function actions(): array
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

        return $setActions;
    }

    /**
     * 清理缓存.
     *
     * @return array|object[]|string[]
     */
    public function actionClearCache(): array
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
        $data = Yii::$app->request->post('bloc', '');
        if ($data) {
            $key = Yii::$app->user->identity->id . 'globalBloc';
            Yii::$app->cache->set($key, $data);

            return ResultHelper::json(200, '切换成功', Yii::$app->cache->get('globalBloc'));
        } else {
            return ResultHelper::json(200, '切换失败', []);
        }
    }

    public function actionStore(): array
    {
        return ResultHelper::json(200, '切换失败', []);
    }

    public function actionThem(): array
    {
        $themcolor = \Yii::$app->request->input('themcolor');

        $this->cache->set('themcolor', $themcolor);
        $data = Yii::$app->request->input();
        return ResultHelper::json(200, '主题设置成功', [
            'themcolor' => $data,
            'themcolorCache' => $this->cache->get('themcolor'),
        ]);
    }
}
