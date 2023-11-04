<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 10:30:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-25 16:45:41
 */

namespace addons\diandi_tea;

use addons\diandi_tea\services\NotifyService;
use common\components\addons\AddonsModule;
use common\helpers\loggingHelper;

/**
 * diandi_dingzuo module definition class.
 */
class api extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_tea\api";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }

    // 支付回调
    // {
    //     "appid": "wx028eb56f4b4a7d99",
    //     "bank_type": "OTHERS",
    //     "cash_fee": "5",
    //     "fee_type": "CNY",
    //     "is_subscribe": "N",
    //     "mch_id": "1228641802",
    //     "nonce_str": "5e6be567474bb",
    //     "openid": "oE5EC0aqNTAdAXpPfikBpkHiSG1o",
    //     "out_trade_no": "2020031455505497",
    //     "result_code": "SUCCESS",
    //     "return_code": "SUCCESS",
    //     "sign": "99C78A7B9A9110E9A4EA4D5040596700",
    //     "time_end": "20200314035649",
    //     "total_fee": "5",
    //     "trade_type": "JSAPI",
    //     "transaction_id": "4200000518202003141950666245"
    // }
    /**
     * Undocumented function.
     *
     * @param [type] $params
     *
     * @return void
     * @throws \Throwable
     */
    public function Notify($params): void
    {
        loggingHelper::writeLog('diandi_tea', 'Notify', '模块内回调');
        NotifyService::Notify($params);
    }
}
