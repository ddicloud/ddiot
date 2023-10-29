<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-08 17:34:08
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-16 18:45:51
 */


namespace common\plugins\diandi_cloud;

use common\components\addons\PluginsModule;
use common\helpers\ArrayHelper;
use common\helpers\loggingHelper;
use common\plugins\diandi_cloud\models\MemberExpand;
use common\plugins\diandi_cloud\models\enums\{
    MemberCertStatus,
    MemberCertType,
    MemberIsDeveloper,
    MemberCertGoldStatus,
};

/**
 * diandi_dingzuo module definition class.
 */
class api extends PluginsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "common\plugins\diandi_cloud\api";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }

    public function Notify($params)
    {
        $memberExpandInfo = MemberExpand::find()->where(['pay_no' => $params['out_trade_no']])->select('cert_gold_status, pay_no, pay_at, member_id')->one();
        if ($memberExpandInfo['cert_gold_status'] != MemberCertGoldStatus::INVALID) {
            if (!$memberExpandInfo['pay_at']) {
                loggingHelper::writeLog('diandi_cloud', 'Notify', '认证金支付订单回调异常', $memberExpandInfo->getAttributes());
            }
            return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        } else {
            $transaction = MemberExpand::getDb()->beginTransaction();
            try {
                $memberExpand = MemberExpand::find()->where('member_id = ' . $memberExpandInfo->id . ' for update')->one();
                $memberExpand->paySuccess();
                if (!$memberExpand->save(false)) {
                    $transaction->rollBack();
                    loggingHelper::writeLog('diandi_cloud', 'Notify', '认证金更改状态异常', $memberExpand->errors);
                    return false;
                }
                \common\models\DdCorePaylog::updateAll(['status' => 1], ['uniontid' => $params['out_trade_no']]);
                $transaction->commit();
                return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_cloud', 'Notify', '认证金更改状态异常 - Exception', $e->getMessage());
                return false;
            }
        }
    }
}
