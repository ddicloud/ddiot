<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-16 15:14:55
 */

namespace addons\diandi_tea\frontend;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @SWG\Swagger(
 *     schemes={"Http"},
 *     host="www.ai.com/api",
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="店滴AI接口文档",
 *     description="店滴AI接口文档",
 *         @SWG\Contact(
 *             name="王春生",
 *             email="2192138785@qq.com"
 *         )),
 * )
 */
class DocController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return  [
            'index' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                // 'restUrls' => Url::to(['doc/json-schema']),
                'restUrl' => [
                    ['url' => Url::to(['doc/json-base']), 'name' => '智能茶室前端api'],
                    ['url' => Url::to(['doc/admin-base']), 'name' => '智能茶室前端后台接口'],
                ],
                'view' => '@frontend/views/apidoc/index',
            ],
            'json-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@addons/diandi_tea/api'),
                    Yii::getAlias('@frontend/controllers/api'),
                ],
                'cacheKey' => 'diandi_tea-api',
            ],
            'admin-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@addons/diandi_tea/admin'),
                    Yii::getAlias('@frontend/controllers/pro'),
                ],
                'cacheKey' => 'diandi_tea-admin',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
