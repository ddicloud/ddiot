<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-24 15:41:56
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-26 10:50:29
 */

namespace common\plugins\diandi_hub\models;

use Yii;
use common\plugins\diandi_cloud\models\enums\{
    MemberCertStatus,
    MemberCertType,
    MemberIsDeveloper,
    MemberCertGoldStatus,
};

class MemberExpand extends \addons\diandi_cloud\models\MemberExpand
{
    /**
     * 验证管理员对应开发者的认证权限
     * @date 2022-09-26 周一
     * @author Radish <minradish@163.com>
     * @param int $adminId
     * @return bool
     */
    public static function checkAdminCert($adminId)
    {
        $model = self::find()->where(['admin_id' => $adminId])->one();
        if (!$model) {
            return '请注册成为开发者！';
        } else if ($model->is_developer == MemberIsDeveloper::INVALID) {
            return '请注册成为开发者！';
        } else if ($model->cert_gold_status == MemberCertGoldStatus::INVALID) {
            return '请支付认证金！';
        } else if ($model->cert_status == MemberCertStatus::INVALID) {
            return '请完成认证！';
        } else if ($temp = self::checkRelease() !== true) {
            return $temp;
        } else {
            return true;
        }
    }

    /**
     * 验证应用发布权限 - 需要完成【官方任务池】后才有权限
     * 【需要完成任务后解锁（官方任务池中任意一个）】
     * @date 2022-09-24
     * @author Radish
     */
    public static function checkRelease()
    {
        return '需要完成任务后解锁!';
    }
}
