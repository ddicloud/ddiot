<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-27 23:01:41
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-15 15:18:49
 */

namespace common\plugins\diandi_hub\api;

use Yii;
use api\controllers\AController;
use common\helpers\ResultHelper;


/**
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="www.wayfiretech.com",
 *     basePath="/api/diandi_hub/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(
 *          version="1.0", title="应用中心",
 *          description="应用中心 - 前台",
 *          @SWG\Contact(name="Radish", email="minradish@163.com")
 *     ),
 *     @SWG\Parameter(in="header", name="store-id", type="string", description="商户ID", required=true),
 *     @SWG\Parameter(in="header", name="bloc-id", type="string", description="公司ID", required=true),
 *     @SWG\Parameter(in="header", name="refresh_token", type="string", description="刷新token令牌", required=true),
 *     @SWG\Parameter(in="header", description="用户access-token", name="access-token", type="string", required=false)
 * )
 */

class ApiController extends AController
{
    public $modelClass = '';

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
                'url' => Yii::$app->request->hostInfo . '/api/diandi_hub/api/json-base',
                'name' => '前台接口',
            ],
            [
                'url' => Yii::$app->request->hostInfo . '/api/diandi_hub/api/admin-base',
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
