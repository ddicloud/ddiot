<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 00:28:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-04 11:49:23
 */

namespace api\controllers; 

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="dev.hopesfire.com",
 *     basePath="/api/",
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
 *      required=false
 *   )
 * )
 */
class DocController extends Controller
{
    // public $defaultRoute = 'Index';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => [
                    ['url' => Url::to(['api/doc/json-inits']), 'name' => '基础接口'],
                    ['url' => Url::to(['api/doc/json-wechat']), 'name' => '小程序接口'],
                    ['url' => Url::to(['api/doc/json-officialaccount']), 'name' => '公众号接口'],
                ]
            ],
            // 小程序接口
            'admin' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@admin/controllers'),
                ],
                'cacheKey' => 'swagger-admin',
            ],
            // 小程序接口
            'json-officialaccount' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@api/modules/officialaccount/controllers'),
                ],
                'cacheKey' => 'swagger-wechat',
            ],
            // 小程序接口
            'json-wechat' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@api/modules/wechat/controllers'),
                ],
                'cacheKey' => 'swagger-wechat',
            ],
            /* 基础接口:登录注册、人脸识别 */
            'json-inits' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@api/controllers'),
                ],
                'cacheKey' => 'swagger-inits',
            ],
        ];
    }
}
