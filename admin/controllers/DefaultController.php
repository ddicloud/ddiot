<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:06:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-22 11:01:28
 */

namespace admin\controllers;

use common\helpers\ResultHelper;

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
class DefaultController extends AController
{
    public $modelClass = '';

    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionIndex(): array
    {
        global $_GPC;
        return ResultHelper::json(200,'获取成功');

    }
}
