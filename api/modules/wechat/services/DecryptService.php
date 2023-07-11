<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-07-11 13:06:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-11 13:31:27
 */

namespace api\modules\wechat\services;

use common\helpers\ResultHelper;
use common\services\BaseService;

class DecryptService extends BaseService
{
    /**
     * 小程序通过code解密数据
     * @param array $data
     * @date 2022-08-09
     * @author Radish
     */
    public static function decryptWechatData($encryptedData, $iv, $code)
    {
        if (empty($encryptedData)) {
            return ResultHelper::json(400, 'encryptedData is requred');
        }

        if (empty($iv)) {
            return ResultHelper::json(400, 'iv is requred');
        }

        if (empty($code)) {
            return ResultHelper::json(400, 'code is requred');
        }

        if ($encryptedData && $iv && $code) {
            $miniProgram = \Yii::$app->wechat->miniProgram;
            $user = $miniProgram->auth->session($code);
            if (isset($user['session_key'])) {
                $decryptData = $miniProgram->encryptor->decryptData($user['session_key'], $iv, $encryptedData);

                return ResultHelper::json(200, '解密成功', $decryptData);
            } else {
                return ResultHelper::json(400, 'session_key 不存在', $user);
            }
        }
    }
}
