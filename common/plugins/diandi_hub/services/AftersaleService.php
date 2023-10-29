<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 04:22:42
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-26 18:51:18
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\account\HubAccountLog;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\AftersaleStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\enums\RefundStatus;
use common\plugins\diandi_hub\models\enums\RefundType;
use common\plugins\diandi_hub\models\order\DiandiHubRefundReason;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\plugins\diandi_hub\models\order\HubRefundLog;
use common\plugins\diandi_hub\models\order\HubRefundOrder;
use common\plugins\diandi_hub\models\Searchs\account\HubAccountOrder;
use common\plugins\diandi_hub\services\account\logAccount;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\models\DdRegion;
use common\models\PayRefundLog;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

/**
 * Class SmsService.
 *
 * @author chunchun <2192138785@qq.com>
 */
class AftersaleService extends BaseService
{
    public static function getRefundInfo()
    {
        $refundType = RefundType::listData();
        $Reason = DiandiHubRefundReason::find()->asArray()->all();

        if (!empty(Yii::$app->cachehelper->get('RefundInfo'))) {
            return Yii::$app->cachehelper->get('RefundInfo');
        }

        $list = [
            'refundType' => $refundType,
            'Reason' => $Reason,
        ];

        Yii::$app->cachehelper->set('RefundInfo', $list);

        return $list;
    }

    // return 1成功2失败3重复申请
    public static function addAfterService($order_id, $reason_id, $money, $type, $remark, $member_id, $thumbs, $linkman, $mobile, $goods_id)
    {
        loggingHelper::writeLog('diandi_hub', 'AftersaleService', '申请退款开始', $order_id);

        // 首先看是否已经有申请记录
        $HubRefundOrder = new HubRefundOrder();
        $orderHave = $HubRefundOrder->find()->where(['order_id' => $order_id])->select('id')->one();
        if ($orderHave) {
            loggingHelper::writeLog('diandi_hub', 'AftersaleService', '订单重复退款', []);

            return [
                'status' => 0,
                'msg' => '订单重复退款',
            ];
        }
        $orderInfo = OrderService::detail($order_id);

        if ($money > $orderInfo['total_price']) {
            return [
                'status' => 0,
                'msg' => '退款金额大于订单金额',
            ];
        }

        $orderInfo = HubOrder::findOne($order_id);

        $refund_status = RefundStatus::getValueByName('申请');
        $status = AftersaleStatus::getValueByName('已申请');

        $refund_code = self::CreateRefundno();
        $data = [
            'order_id' => $order_id,
            'reason_id' => $reason_id,
            'transaction_id' => $orderInfo['transaction_id'],
            'refund_code' => $refund_code,
            'money' => $money,
            'type' => $type,
            'refund_status' => $refund_status,
            'status' => $status,
            'remark' => $remark,
            'member_id' => $member_id,
            'thumbs' => $thumbs,
            'linkman' => $linkman,
            'mobile' => $mobile,
            'goods_id' => $goods_id,
            'order_status' => $orderInfo['order_status'],
        ];

        loggingHelper::writeLog('diandi_hub', 'AftersaleService', '订单退款数据', $data);

        $transaction = HubRefundOrder::getDb()->beginTransaction();

        try {
            $HubRefundOrder->load($data, '');
            if ($HubRefundOrder->save()) {
                loggingHelper::writeLog('diandi_hub', 'AftersaleService', '订单退款数据写入成功', $data);

                // 更新订单状态
                $orderStatus = OrderStatus::getValueByName('申请售后');
                $Res = HubOrder::updateAll(['order_status' => $orderStatus], ['order_id' => $order_id]);

                loggingHelper::writeLog('diandi_hub', 'AftersaleService', '原始订单数据更新结果', $Res);

                // 退款退货和退款都需要退钱，所以需要写入退款日志
                if ($type != RefundType::getValueByName('换货')) {
                    $Res = self::addRefundLog($member_id, $refund_code, $money, '申请退款', $orderInfo['total_price'], $orderInfo['transaction_id']);
                }
            } else {
                $msg = ErrorsHelper::getModelError($HubRefundOrder);
                loggingHelper::writeLog('diandi_hub', 'AftersaleService', '售后', $msg);

                return [
                    'status' => 0,
                    'msg' => '日志写入错误',
                ];

                ErrorsHelper::throwError(0, $msg);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'AftersaleService', 'Exception错误', ErrorsHelper::throwMsg($e));
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'AftersaleService', 'Throwable错误', ErrorsHelper::throwMsg($e));
            throw $e;
        }

        return [
            'status' => 1,
            'msg' => '售后申请成功',
        ];
    }

    public static function addRefundLog($member_id, $out_refund_no, $refund_fee, $refund_status, $total_fee, $transaction_id)
    {
        loggingHelper::writeLog('diandi_hub', 'AftersaleService', '开始写入系统退款日志', []);

        $module = 'diandi_hub';

        $refundData = [
            'out_refund_no' => $out_refund_no, //'商户退款单号',
            'refund_fee' => $refund_fee, //'申请退款金额 ',
            'refund_status' => $refund_status, //'退款状态',
            'module' => $module, // '模块标识',
            'total_fee' => $total_fee, // '订单金额 ',
            'transaction_id' => $transaction_id, // '微信订单号',
            'member_id' => $member_id, //'用户id'
        ];

        loggingHelper::writeLog('diandi_hub', 'AftersaleService', '写入系统退款日志数据', $refundData);

        $PayRefundLog = new PayRefundLog();
        $PayRefundLog->load($refundData, '');
        if (!$PayRefundLog->save()) {
            $msg = ErrorsHelper::getModelError($PayRefundLog);
            loggingHelper::writeLog('diandi_hub', 'AftersaleService', '退款日志写入失败', $msg);

            return false;
        } else {
            return true;
        }

        loggingHelper::writeLog('diandi_hub', 'AftersaleService', '写入系统退款日志完成', []);
    }

    public static function confirmRefund($order_id, $status, $refund_status)
    {
        $HubRefundOrder = new HubRefundOrder();
        $refundOrder = $HubRefundOrder->find()->where(['order_id' => $order_id])->select(['id', 'transaction_id', 'refund_code', 'member_id', 'goods_id'])->one();

        $goods_ids = $refundOrder['goods_id'];

        $orderInfo = HubOrder::find()->where(['order_id' => $order_id])->one();

        $pay_type = $orderInfo['pay_type'];

        // 售后状态:0申请1拒绝售后2处理中3已处理4已完结
        switch ($status) {
            case AftersaleStatus::getValueByName('已申请'):

                break;
            case AftersaleStatus::getValueByName('被驳回'):

                break;
            case AftersaleStatus::getValueByName('处理中'):

                break;
            case AftersaleStatus::getValueByName('已处理'):

                break;
            case AftersaleStatus::getValueByName('已完结'):
                // 处理订单状态id
                $orderStatus = OrderStatus::getValueByName('已经售后');
                HubOrder::updateAll(['order_status' => $orderStatus], ['order_id' => $order_id]);
                break;

            default:

                break;
        }

        $refundEnd = HubRefundLog::find()->orderBy(['create_time' => SORT_DESC])->one();

        $wechat = Yii::$app->wechat->payment;

        loggingHelper::writeLog('diandi_hub', 'confirmRefund', '申请退款', [
            'pay_type' => $pay_type,
            'refund_status' => $refund_status,
            'res' => $wechat->refund->queryByOutRefundNumber($refundOrder['refund_code']),
        ]);

        if ($pay_type == PayTypeStatus::getValueByName('微信支付')) {
            if ($refund_status == RefundStatus::getValueByName('退款中')) {
                $Res = $wechat->refund->queryByOutRefundNumber($refundOrder['refund_code']);

                if ($Res['result_code'] == 'SUCCESS' && $Res['return_code'] == 'SUCCESS') {
                    return true;
                }

                self::refundMoney($refundOrder['id'], $refundEnd['money'], $config = [
                    'refund_desc' => $refundEnd['remark'],
                ]);
            }
        } elseif ($pay_type == PayTypeStatus::getValueByName('余额支付')) {
            // 写日志
            // 资金变化类型
            $change_type = AccountChangeStatus::getValueByName('退款');

            // 资金类型
            $account_type = AccountTypeStatus::getValueByName('余额');

            // 团队奖励资金日志写入
            $order_goods_id = 0;

            $order_type = $orderInfo['order_type'];

            if ($refund_status == RefundStatus::getValueByName('退款中')) {
                if (!StringHelper::strExists($goods_ids, ',')) {
                    $orderGoods = HubOrderGoods::find()->where([
                        'order_id' => $order_id,
                        'goods_id' => intval($goods_ids),
                    ])->asArray()->one();

                    $goods_type = $orderGoods['goods_type'];

                    $goods_price = $orderGoods['goods_price'];

                    $performance = 0;

                    $goods_id = intval($goods_ids);
                } else {
                    $goods_type = GoodsTypeStatus::getValueByName('其他商品');

                    $goods_price = $refundEnd['money'];

                    $performance = 0;

                    $goods_id = 0;
                }

                $account_log_id = logAccount::addorderMoneyLog($refundOrder['member_id'], $order_id, $refundEnd['money'], $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $orderInfo['total_price'], $goods_id, $goods_price, $performance);

                // 退余额
                $Res = MemberService::updateAccountBymid($refundOrder['member_id'], 'credit1', $refundEnd['money'], $account_log_id);

                $refund_status = RefundStatus::getValueByName('已退款'); //直接变更为已退款
            }
        }

        $HubRefundOrder->updateAll([
            'status' => $status,
            'refund_status' => $refund_status,
        ], ['order_id' => $order_id]);
    }

    /**
     * 微信退款.
     *
     * @param [number] $refund_id
     * @param float    $refundFee
     * @param array    $config
     *
     * @return void
     */
    public static function refundMoney($refund_id, $refundFee, $config = [])
    {
        $HubRefundOrder = new HubRefundOrder();

        $RefundInfo = $HubRefundOrder::find()->where(['id' => $refund_id])->with(['order'])->asArray()->one();

        $transactionId = $RefundInfo['transaction_id'];
        $refundNumber = $RefundInfo['refund_code'];
        $totalFee = $RefundInfo['order']['total_price'];

        $wechat = Yii::$app->wechat->payment;

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundMoney', '退款开始', [
            'transactionId' => $transactionId,
            'refundNumber' => $refundNumber,
            'totalFee' => $totalFee,
            'refundFee' => $refundFee,
            'config' => $config,
        ]);

        // [
        //     // 可在此处传入其他参数，详细参数见微信支付文档
        //     'refund_desc' => '商品已售完',
        // ]
        // 参数分别为：微信订单号、商户退款单号、订单金额、退款金额、其他参数
        $totalFeeNum = intval(strval($totalFee * 100));
        $refundFeeNum = intval(strval($refundFee * 100));
        $result = $wechat->refund->byTransactionId($transactionId, $refundNumber, $totalFeeNum, $refundFeeNum, $config);
        if ($result['return_code'] == 'FAIL') {
            // 退款申请失败
        }

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundMoney', '退款返回结果', $result);

        return $result;
    }

    // 生成订单编号
    public static function CreateRefundno()
    {
        return 'Ref' . date('Ymd') . substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    // 订单列表
    public static function list($user_id, $order_status, $pageSize)
    {
        $page = Yii::$app->request->get('page');

        $where = []; //初始化条件数组
        $where['member_id'] = $user_id;
        if (is_numeric($order_status)) {
            $where['status'] = $order_status;
        }

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
            $condition['bloc_id'] = $bloc_id;
        }

        if ($store_id) {
            $where['store_id'] = $store_id;
            $condition['store_id'] = $store_id;
        }

        $query = HubRefundOrder::find()
            ->where($where)
            ->with(['order', 'orderGoods'])
            ->orderBy('create_time desc');

        // 得到订单的总数（但是还没有从数据库取数据）
        $count = $query->count();
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
        ]);

        $list = $query->offset($pagination->offset)
            ->asArray()
            ->limit($pagination->limit)
            ->all();

        $goods_id_alls = array_column($list, 'goods_id');
        $goods_id_all = implode(',', $goods_id_alls);
        $goodsAll = HubOrderGoods::find()->where(['IN', 'goods_id', $goods_id_all])->indexBy('goods_id')->asArray()->all();

        foreach ($list as &$item) {
            $item['create_time'] = date('m-d H:i:s', $item['create_time']);
            $item['status_label'] = OrderStatus::getLabel($item['order_status']);
            $goods_ids = explode(',', $item['goods_id']);
            $item['goods_count'] = count($goods_ids);
            $item['refund_type'] = RefundType::getLabel($item['type']);
            $item['status_label'] = AftersaleStatus::getLabel($item['status']);

            if (!empty($item['orderGoods'])) {
                foreach ($item['orderGoods'] as $key => &$value) {
                    if (in_array($value['goods_id'], $goods_ids)) {
                        $value['is_after'] = 1;
                    }
                }
            }
        }

        return $list;
    }

    public static function detail($order_id)
    {
        $DdOrder = new HubOrder();
        $detail = $DdOrder->find()
            ->with(['address', 'express', 'refund', 'refundLog'])
            ->where(['order_id' => $order_id])
            ->asArray()->one();
        $region = DdRegion::find()->where(['id' => $detail['address']['region_id']])->select('merger_name')->one();
        $detail['address']['address_detail'] = $region['merger_name'];
        $goods_id_alls = array_column($detail, 'goods_id');
        $goods_id_all = explode(',', $detail['refund']['goods_id']);

        $detail['goods'] = HubOrderGoods::find()->where(['IN', 'goods_id', $goods_id_all])->andWhere(['order_id' => $order_id])->indexBy('goods_id')->asArray()->all();

        $detail['pay_time'] = date('Y-m-d H:i:s', $detail['pay_time']);
        $detail['receipt_time'] = date('Y-m-d H:i:s', $detail['receipt_time']);
        $detail['create_time'] = date('Y-m-d H:i:s', $detail['create_time']);

        $detail['status_label'] = OrderStatus::getLabel($detail['order_status']);

        if (!empty($detail['refundLog'])) {
            foreach ($detail['refundLog'] as $key => &$value) {
                $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
                $value['status_str'] = RefundStatus::getLabel($value['status']);
            }
        }

        return $detail;
    }

    /**
     * 微信退款处理.
     *
     * @param [type] $out_refund_no
     *
     * @return void
     */
    public static function refundWechat($out_refund_no)
    {
        loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '微信退款处理开始', $out_refund_no);

        $RefundOrder = HubRefundOrder::find()->where([
            'refund_code' => $out_refund_no,
        ])->one();

        if ($RefundOrder['refund_status'] == RefundStatus::getValueByName('已退款')) {
            loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '订单已退款处理');

            // 已退款未完结，更新为已完结
            if ($RefundOrder['status'] != AftersaleStatus::getValueByName('已完结')) {
                loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '未完结处理');

                $Res = HubRefundOrder::updateAll([
                    'status' => AftersaleStatus::getValueByName('已完结'),
                ], [
                    'refund_code' => $out_refund_no,
                ]);

                loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '完结更新结果', $Res);
            }

            return true;
        }

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '准备处理退款后的日志和订单佣金');

        $Res = self::rundAccountOrder($RefundOrder);

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '退款后，日志处理与订单佣金处理结果', $Res);

        if ($Res) {
            $Res = HubRefundOrder::updateAll([
                'refund_status' => RefundStatus::getValueByName('已退款'),
                'status' => AftersaleStatus::getValueByName('已完结'),
            ], [
                'refund_code' => $out_refund_no,
            ]);

            loggingHelper::writeLog('diandi_hub', 'AftersaleService/refundWechat', '退款单状态更新', $Res);
        }
    }

    /**
     * 退款后分润处理.
     *
     * @param string $out_refund_no
     *
     * @return void
     */
    public static function rundAccountOrder($out_refund_no)
    {
        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款后分润处理开始', $out_refund_no);

        $RefundOrder = HubRefundOrder::find()->where(['refund_code' => $out_refund_no])->asArray()->one();

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款后分润处理退款信息', $RefundOrder);

        if ($RefundOrder['refund_status'] == RefundStatus::getValueByName('已退款')) {
            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '已退款');

            return true;
        }

        if ($RefundOrder['type'] == RefundType::getValueByName('换货')) {
            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '换货');

            return true;
        }

        $good_ids = explode(',', $RefundOrder['goods_id']);

        $order_id = $RefundOrder['order_id'];
        $member_id = $RefundOrder['member_id'];

        $change_type = AccountChangeStatus::getValueByName('冻结');

        $orderDetail = self::detail($order_id);
        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款的订单信息', $orderDetail);

        $order_goods_ids = [];

        if (!empty($orderDetail['goods'])) {
            foreach ($orderDetail['goods'] as $key => $value) {
                if (in_array($value['goods_id'], $good_ids)) {
                    $order_goods_ids[] = $value['order_goods_id'];
                }
            }
        }

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款的order_goods_id', $order_goods_ids);

        $HubAccountLog = new HubAccountLog();

        $accountLogs = HubAccountLog::find()->where([
            'change_type' => $change_type,
        ])->andWhere(['IN', 'order_goods_id', $order_goods_ids])->asArray()->all();

        $Sql = HubAccountLog::find()->where([
            'change_type' => $change_type,
        ])->andWhere(['IN', 'order_goods_id', $order_goods_ids])->createCommand()->getRawSql();
        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款有关的日志记录sql', $Sql);
        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款有关的日志记录', $accountLogs);
        foreach ($accountLogs as $key => $value) {
            $_HubAccountLog = clone $HubAccountLog;

            $value['is_add'] = $value['is_add'] == 0 ? 1 : 0;
            unset($value['id'], $value['update_time'], $value['create_time']);

            $member_id = $value['member_id'];

            $money = -$value['money'];

            $value['money'] = -$value['money'];

            $value['change_type'] = AccountChangeStatus::getValueByName('退款');

            $_HubAccountLog->setAttributes($value);

            if ($_HubAccountLog->save()) {
                $msg = ErrorsHelper::getModelError($_HubAccountLog);
                $account_type = $value['account_type'];
                $account_log_id = $_HubAccountLog->id;
                switch ($account_type) {
                    case AccountTypeStatus::getValueByName('店铺待发放'):

                        $Res1 = MemberService::updateAccountBymid($member_id, 'store_freeze', $money, $account_log_id, '退款店铺待发放减少');
                        if ($Res1) {
                            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '店铺待发放扣除成功');
                        }

                        break;

                    case AccountTypeStatus::getValueByName('分享待发放'):
                        $Res1 = MemberService::updateAccountBymid($member_id, 'self_freeze', $money, $account_log_id, '退款分享待发放减少');
                        if ($Res1) {
                            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '分享待发放扣除成功');
                        }
                        break;
                    case AccountTypeStatus::getValueByName('团队待发放'):
                        $Res1 = MemberService::updateAccountBymid($member_id, 'team_freeze', $money, $account_log_id, '退款团队待发放减少');
                        if ($Res1) {
                            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '团队待发放扣除成功');
                        }

                        break;
                    case AccountTypeStatus::getValueByName('店铺待发放'):
                        $Res1 = MemberService::updateAccountBymid($member_id, 'store_freeze', $money, $account_log_id, '退款店铺待发放减少');
                        if ($Res1) {
                            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '店铺待发放扣除成功');
                        }

                        break;
                        break;
                    case AccountTypeStatus::getValueByName('代理待发放'):
                        $Res1 = MemberService::updateAccountBymid($member_id, 'agent_freeze', $money, $account_log_id, '退款代理待发放减少');
                        if ($Res1) {
                            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '代理待发放扣除成功');
                        }

                        break;
                        break;
                    case AccountTypeStatus::getValueByName('流水奖金待发放'):
                        $Res1 = MemberService::updateAccountBymid($member_id, 'team_freeze', $money, $account_log_id, '退款流水奖金待发放减少');
                        if ($Res1) {
                            loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '流水奖金待发放扣除成功');
                        }

                        break;
                        break;
                }
            } else {
                $msg = ErrorsHelper::getModelError($_HubAccountLog);
                loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款日志存写错误', [
                    'msg' => $msg,
                ]);
            }
        }

        $Res = HubRefundOrder::updateAll([
            'refund_status' => RefundStatus::getValueByName('已退款'),
        ], ['refund_code' => $out_refund_no]);

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '退款状态修改结果', $Res);

        $Res = HubAccountLog::updateAll([
            'is_refund' => 1,
        ], [
            'and',
            ['change_type' => $change_type],
            ['IN', 'order_goods_id', $order_goods_ids],
        ]);

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '日志标记为退款日志', [
            [
                'is_refund' => 1,
            ], [
                'and',
                ['change_type' => $change_type],
                ['IN', 'order_goods_id', $order_goods_ids],
            ],
            'res' => $Res,
        ]);

        $Res = HubAccountOrder::updateAll([
            'is_refund' => 1,
        ], [
            'and',
            ['order_id' => $order_id],
            ['IN', 'order_goods_id', $order_goods_ids],
        ]);

        loggingHelper::writeLog('diandi_hub', 'AftersaleService/rundAccountOrder', '订单佣金标记为退款佣金', [
            'is_refund' => 1,
        ], [
            'and',
            ['order_id' => $order_id],
            ['IN', 'order_goods_id', $order_goods_ids],
        ]);
    }

    /**
     * 取消售后订单
     * @param [type] $userId
     * @param [type] $refundId
     * @return void
     * @date 2022-07-26
     * @example
     * @author Radish
     * @since
     */
    public static function cancelRefund($userId, $refundId)
    {
        $model = new HubRefundOrder();
        $model = $model->find()->where(['id' => $refundId, 'member_id' => $userId])->select(['id', 'status', 'order_status', 'order_id'])->one();
        if ($model && in_array($model->status, [RefundStatus::STARTREFUND, RefundStatus::NOREFUND])) {
            $orderModel = HubOrder::findOne($model->order_id);
            $model->status = RefundStatus::END;
            $orderModel->order_status = $model->order_status;
            if ($orderModel->save(false) && $model->save(false)) {
                return true;
            } else {
                return current(($model->getFirstErrors() + $orderModel->getFirstErrors()));
            }
        } else {
            return '无效的售后信息，或者当前售后不可取消！';
        }
    }
}
