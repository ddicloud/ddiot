<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-27 23:01:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:18
 */

namespace common\plugins\diandi_hub\admin\api;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class ApiController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            // 'common-json-base' => [
            //     'class' => 'yii2mod\swagger\OpenAPIRenderer',
            //     'scanDir' => [
            //         // Yii::getAlias('@api/controllers'),
            //     ],
            //     'cache' => null,
            //     'cacheKey' => 'diandi_hub-common-json',
            // ],
            'json-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@addons/diandi_hub/api'),
                    // Yii::getAlias('@addons/diandi_hub/docs/common'),
                    // Yii::getAlias('@addons/diandi_hub/docs/fore'),
                ],
                'cache' => null,
                'cacheKey' => 'diandi_hub-api',
            ],
            'admin-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@addons/diandi_hub/admin'),
                    // Yii::getAlias('@addons/diandi_hub/docs/common'),
                    // Yii::getAlias('@addons/diandi_hub/docs/back'),
                ],
                'cache' => null,
                'cacheKey' => 'diandi_hub-admin',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionDocsType()
    {
        return ResultHelper::json(200, '请求成功！', [
            [
                'url' => Yii::$app->request->hostInfo.'/api/diandi_hub/api/json-base',
                'name' => '前台接口',
            ],
            [
                'url' => Yii::$app->request->hostInfo.'/api/diandi_hub/api/admin-base',
                'name' => '后台接口',
            ],
            // [
            //     'url' => Yii::$App->request->hostInfo . '/api/diandi_hub/api/common-json-base',
            //     // 'url' => 'https://petstore.swagger.io/v2/swagger.json',
            //     'name' => '前台公共接口',
            // ],
        ]);
    }

    public function actionTest()
    {
        dd(1);
    }
}
