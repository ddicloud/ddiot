<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 01:39:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-08 09:07:33
 */

namespace common\plugins\diandi_cloud\api;

use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

/**
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="dev.hopesfire.com",
 *     basePath="/api/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="店滴云开发手册",
 *     description="店滴云开发手册",
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
class ApiController extends AController
{
    public $modelClass = '';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'json-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    // Yii::getAlias('@api/controllers'),
                    Yii::getAlias('@addons/diandi_cloud/api'),
                ],
                'cache' => null,
                'cacheKey' => 'diandi_cloud-api',
            ],
            'admin-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    // Yii::getAlias('@admin/controllers'),
                    // Yii::getAlias('@api/controllers'),
                    Yii::getAlias('@addons/diandi_cloud/admin'),
                ],
                'cache' => null,
                'cacheKey' => 'diandi_cloud-admin',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @SWG\Post(path="/diandi_shop/address/add",
     *    tags={"收货地址"},
     *    summary="收货地址添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="收货人",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="phone",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="province_id",
     *     type="integer",
     *     description="省份",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="city_id",
     *     type="integer",
     *     description="城市",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="region_id",
     *     type="integer",
     *     description="区县",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="detail",
     *     type="integer",
     *     description="具体地址",
     *     required=true,
     *   )
     * )
     */
    public function actionIndex()
    {
        global $_GPC;

        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id??0;
        $res = [];

        return ResultHelper::json(200, '请求成功', $res);
    }
}
