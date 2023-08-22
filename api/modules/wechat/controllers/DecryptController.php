<?php


/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-07-11 13:04:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-11 13:22:41
 */

namespace api\modules\wechat\controllers;

use api\controllers\AController;
use api\modules\wechat\services\DecryptService;
use common\helpers\ResultHelper;

class DecryptController extends AController
{
    protected array $authOptional = ['msg'];

    public function actionMsg()
    {
        global $_GPC;

        $encryptedData = $_GPC['encryptedData'];
        $iv = $_GPC['iv'];
        $code = $_GPC['code'];
        $Res = DecryptService::decryptWechatData($encryptedData, $iv, $code);
        return ResultHelper::json(200, '解密成功', $Res);
    }
}
