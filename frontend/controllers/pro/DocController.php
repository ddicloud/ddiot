<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 00:28:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-13 10:14:04
 */

namespace frontend\controllers\pro;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="dev.hopesfire.com",
 *     basePath="/admin/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="店滴接口文档",
 *     description="店滴接口文档",
 *     @SWG\Contact(
 *        name="王春生",
 *        email="2192138785@qq.com"
 *     )),
 *     @SWG\Parameter(
 *      in="header",
 *      name="store-id",
 *      type="string",
 *      description="商户ID",
 *      required=true,
 *    ),
 *     @SWG\Parameter(
 *      in="header",
 *      name="bloc-id",
 *      type="string",
 *      description="公司ID",
 *      required=true,
 *    ),
 *     @SWG\Parameter(
 *      in="header",
 *      name="refresh_token",
 *      type="string",
 *      description="刷新token令牌",
 *      required=true,
 *    ),
 *    @SWG\Parameter(
 *      description="用户access-token",
 *      name="access-token",
 *      type="string",
 *      in="header",
 *      required=true
 *   )
 * )
 */
class DocController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => [
                    ['url' => Url::to(['pro/doc/json-inits']), 'name' => '基础接口'],
                    ['url' => Url::to(['pro/doc/admin']), 'name' => '全局接口'],
                ],
                'view' => '@frontend/views/apidoc/index',
            ],
            /* 基础接口:登录注册、人脸识别 */
            'json-inits' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@frontend/controllers/pro'),
                    Yii::getAlias('@admin/controllers'),
                ],
                'cacheKey' => 'swagger-inits',
            ],
            'admin' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@frontend/controllers/pro'),
                    Yii::getAlias('@admin/controllers'),
                    // Yii::getAlias('@api/models/Definition'),
                ],
                'cacheKey' => 'swagger-admin',
            ],
        ];
    }
}
