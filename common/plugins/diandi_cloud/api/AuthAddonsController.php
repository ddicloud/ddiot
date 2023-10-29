<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 01:39:33
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-12 17:36:13
 */

namespace common\plugins\diandi_cloud\api;

use api\controllers\AController;
use common\helpers\ResultHelper;
use common\plugins\diandi_cloud\services\AddonsService;

class AuthAddonsController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['*'];


    /**
     * @SWG\Post(
     *    path="/diandi_cloud/auth-addons/checkauth",
     *    tags={"应用认证"},
     *    summary="应用认证",
     *    @SWG\Response(response = 200, description = "应用认证结果"),
     *    @SWG\Parameter(in="formData", name="web_key",type="string", description="授权秘钥", required=true),
     *    @SWG\Parameter(in="formData", name="url", type="string", description="授权域名【Http://test.com】", required=true),
     *    @SWG\Parameter(in="formData", name="addons", type="string", description="授权模块", required=true),
     * )
     */
    public function actionCheckAuth()
    {
        global $_GPC;
        // 当前系统已经安装的应用
        $bool = AddonsService::authAddons($_GPC['web_key'], $_GPC['url'], $_GPC['addons']);
        if ($bool === true) {
            return ResultHelper::json(200, '请求成功', $bool);
        } else {
            return ResultHelper::json(401, $bool);
        }
    }

    /**
     * @SWG\Post(
     *    path="/diandi_cloud/auth-addons/check-domain",
     *    tags={"授权域名认证"},
     *    summary="授权域名认证",
     *    @SWG\Response(response = 200, description = "授权域名认证结果"),
     *    @SWG\Parameter(in="formData", name="url", type="string", description="授权域名【Http://test.com】", required=true),
     * )
     */
    public function actionCheckDomain()
    {
        global $_GPC;
        $bool = AddonsService::authDomain($_GPC['url']);
        if ($bool === true) {
            return ResultHelper::json(200, '请求成功', $bool);
        } else {
            return ResultHelper::json(401, $bool);
        }
    }
}
