<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 10:30:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-05-17 13:40:13
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use common\services\BaseService;
use Yii;

/**
 * diandi_dingzuo module definition class.
 */
class NoticeService extends BaseService
{
    /**
     * 预约到期通知
     * 订单号、预约门店、预约时间、地址
     * @param [type] $data
     * @param [type] $store_id
     * @return array
     * @date 2023-05-17
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function Subscribe($data, $store_id): array
    {
        $openid = $data['openid'];
        $msg_template = TeaGlobalConfig::find()->where(['store_id' => $store_id])->select('order_end_template')->scalar();

        $info = [
            'template_id' => trim($msg_template), // 所需下发的订阅模板id
            'touser' => $openid,     // 接收者（用户）的 openid
            //'page' => 'pages/reserve/reserve',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'page' => 'teahouse/orderDetail/orderDetail?id=' . $data['order_id'],
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'character_string1' => [    //订单号
                    'value' => $data['order_num'],
                ],
                'thing4' => [       //预约门店
                    'value' => $data['hourse_name'],
                ],
                'date3' => [        //预约时间
                    'value' => $data['start_time'],
                ],
                'thing5' => [       //地址
                    'value' => $data['address'],
                ],
                'thing6' => [       //备注
                    'value' => '您预约的活动即将开始，请点击参与',
                ],
            ],
        ];
        $miniProgram = Yii::$app->wechat->miniProgram;

        return  $miniProgram->subscribe_message->send($info);
    }

    /**
     * 订单下单提醒
     * 商品名称、订单编号、支付金额、备注
     * @param [type] $data
     * @return array
     * @date 2023-05-17
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function OrderNotice($data): array
    {
        $openid = $data['openid'];
        $msg_template = TeaGlobalConfig::find()->where(['store_id' => $data['store_id']])->select('order_create_template')->scalar();

        $info = [
            'template_id' => trim($msg_template), // 所需下发的订阅模板id
            'touser' => $openid,     // 接收者（用户）的 openid
            //'page' => 'pages/reserve/reserve',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'page' => 'teahouse/orderDetail/orderDetail?id=' . $data['order_id'],
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'thing11' => [  //商品名称
                    'value' => $data['hourse_name'],
                ],
                'character_string2' => [   //订单编号
                    'value' => $data['order_num'],
                ],
                'amount1' => [  //支付金额
                    'value' => $data['price'],
                ],
                'thing7' => [   //备注
                    'value' => '感谢您预定点到为止共享茶室,请点击参与',
                ],
            ],
        ];
        $miniProgram = Yii::$app->wechat->miniProgram;

        return  $miniProgram->subscribe_message->send($info);
    }

    /**
     * 充值成功通知
     * 充值金额、充值时间、赠送金额、备
     * @param [type] $data
     * @return array
     * @date 2023-05-17
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function RechargeNotice($data): array
    {
        $msg_template = TeaGlobalConfig::find()->where(['store_id' => $data['store_id']])->select('recharge_template')->scalar();

        $openid = $data['openid'];
        $info = [
            'template_id' => trim($msg_template), // 所需下发的订阅模板id
            'touser' => $openid,     // 接收者（用户）的 openid
            // 'page' => '',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'amount3' => [  //充值金额
                    'value' => $data['price'],
                ],
                'date5' => [   //充值时间
                    'value' => $data['time'],
                ],
                'amount6' => [  //赠送金额
                    'value' => $data['give_price'],
                ],
                'thing7' => [   //备注
                    'value' => '充值成功,请注意查收',
                ],
                'thing9' => [   //商户名称
                    'value' => '点到为止共享茶室',
                ],
            ],
        ];
        $miniProgram = Yii::$app->wechat->miniProgram;

        return  $miniProgram->subscribe_message->send($info);
    }

    /**
     * 订到到期续费通知
     * 房间订单续费提醒	温馨提示、距离结束
     * @param [type] $data
     * @param [type] $store_id
     * @return array
     * @date 2023-05-17
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function Renew($data, $store_id): array
    {
        $openid = $data['openid'];

        $msg_template = TeaGlobalConfig::find()->where(['store_id' => $store_id])->select('renew_template')->scalar();
        $info = [
            'template_id' => trim($msg_template), // 所需下发的订阅模板id
            'touser' => $openid,     // 接收者（用户）的 openid
            //'page' => 'teahouse/order/order',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'page' => 'teahouse/orderDetail/orderDetail?id=' . $data['order_id'],
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'thing1' => [    //温馨提示
                    'value' => '您好，当前房间时间不足十分钟，如需加钟请点击下方链接',
                ],
                'time2' => [       //距离结束
                    'value' => $data['end_time'],
                ],
            ],
        ];
        $miniProgram = Yii::$app->wechat->miniProgram;

        return  $miniProgram->subscribe_message->send($info);
    }
}
