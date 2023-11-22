<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-24 11:27:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-13 14:09:45
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\enums\OrderStatus;
use addons\diandi_tea\models\order\TeaInvoice;
use addons\diandi_tea\models\order\TeaOrderList;
use addons\diandi_tea\models\order\TeaRechargeList;
use common\helpers\DateHelper;
use common\helpers\ImageHelper;
use common\models\AccountLog;
use common\models\DdMember;
use common\models\DdMemberAccount;
use common\services\BaseService;
use yii\data\Pagination;

class MemberService extends BaseService
{
    public static function info($member_id): array|\yii\db\ActiveRecord
    {
        $info = DdMember::find()
            ->select(['username', 'mobile', 'gender', 'nickName', 'avatarUrl', 'level', 'member_id'])
            ->where(['member_id' => $member_id])
            ->asArray()
            ->one();

        $info['avatarUrl'] = ImageHelper::tomedia($info['avatarUrl']);


        if ($info['level'] == 2) {
            $info['saveMoney'] = TeaOrderList::find()
                ->where(['member_id' => $member_id])
                ->sum('discount');
            // $info['saveMoney'] = TeaOrderList::find()
            //     ->select('SUM(discount) AS saveMoney')
            //     ->where(['member_id' => $member_id])
            //     ->orderBy('member_id')
            //     ->asArray()->one()['saveMoney'];
        }

        // var_dump($info);die;
        $data = DdMemberAccount::find()
            ->select(['user_money', 'user_integral'])
            ->where(['member_id' => $member_id])
            ->asArray()
            ->one();
        //余额充值明细
        // $query = TeaRechargeList::find();
        // $count = $query->count();

        // // 使用总数来创建一个分页对象
        // $pagination = new Pagination([
        //     'totalCount' => $count,
        //     'pageSize' => $pageSize,
        //     'page' => $page - 1,
        //     'pageParam' => 'page',
        // ]);
        // $info['user_money'] = $query
        //         ->where(['member_id' => $member_id])
        //         ->orderBy(['create_time' => SORT_DESC])
        //         ->limit($pagination->limit)
        //         ->asArray()
        //         ->all();
        $info['user_money'] = $data['user_money'];
        $info['user_integral'] = $data['user_integral'];

        return $info;
    }

    public static function balance($member_id): array
    {
        $month = [];
        //用户余额充值记录
        $info['recharge_list'] = TeaRechargeList::find()
            ->with('recharge')
            ->where(['member_id' => $member_id, 'status' => 2])
            ->select(['*', "DATE_FORMAT(create_time,'%Y-%m') AS month"])
            //->groupBy('month')
            ->asArray()
            ->all();
        foreach ($info['recharge_list'] as &$v) {
            $v['pay_time'] = date('Y-m-d H:i', strtotime($v['pay_time']));
            $v['all_money'] = number_format($v['price'] + $v['recharge']['give_money'], 2);
            $v['price'] = floor($v['price']);
            $v['recharge']['give_money'] = floor($v['recharge']['give_money']);

            $v['is_have'] = TeaInvoice::find()->where(['order_id' => $v['id'], 'type' => 2])->asArray()->one() ? 1 : 2;
            $month[$v['month']][] = $v;
        }

        $data = [];
        $a = 0;
        foreach ($month as $ke => $valu) {
            $data[$a]['time'] = $ke;
            $data[$a]['data'] = $valu;
            $a = $a + 1;
        }

        $info['recharge_list'] = $data;

        //用户余额消费记录
        $order_list = AccountLog::find()
            ->where(['member_id' => $member_id, 'account_type' => ['tea_buy_coupon_balance', 'tea_order_balance', 'tea_member_renew_money_balance', 'tea_member_money_balance']])
            ->select(['*', "FROM_UNIXTIME(create_time,'%Y-%m') as month"])
            ->orderBy(['create_time' => SORT_DESC])
            ->asArray()
            ->all();

        $month = [];
        foreach ($order_list as &$val) {
            $val['s_money'] = number_format($val['money'] + $val['old_money'], 2);
            $val['money'] = number_format($val['money'], 2);
            $val['create_time'] = date('Y-m-d H:i:s', $val['create_time']);
            $month[$val['month']][] = $val;
        }

        $data = [];
        $a = 0;
        foreach ($month as $ke => $valu) {
            $data[$a]['time'] = $ke;
            $data[$a]['data'] = $valu;
            $a = $a + 1;
        }

        $info['order_list'] = $data;

        return $info;
    }

    public static function order($member_id, int $pageSize = 20, int $page = 1, $data = ''): array
    {
        $where = [];
        if (is_array($data)) {
            //我的预定
            if (isset($data['type']) && $data['type'] == 1) {
                //$where['status'] = 2;
                $where['status'] = [1, 2];
                $where['order_type'] = 1;
            } else {
                //我的订单
                if (isset($data['status']) && $data['status']) {
                    $where['status'] = $data['status'];
                    //$where['status'] = [1, 2];
                }
                if (isset($data['order_type'])) {
                    $where['order_type'] = $data['order_type'];
                } else {
                    $where['order_type'] = 1;
                }
            }
        }

        $where['member_id'] = $member_id;

        $query = TeaOrderList::find();
        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            'pageParam' => 'page',
        ]);

        $member = DdMember::find()
            ->select(['nickName'])
            ->where(['member_id' => $member_id])
            ->asArray()
            ->one();

        $info = $query->where(['member_id' => $member_id])
            ->with(['hourse', 'coupon'])
            ->select(['id', 'start_time', 'end_time', 'balance', 'discount', 'amount_payable', 'real_pay', 'order_number', 'status', 'hourse_id', 'coupon_id', 'create_time', 'pay_type', 'status AS sss'])
            ->orderBy(['create_time' => SORT_DESC])
            ->where($where)
            ->limit($pagination->limit)
            ->asArray()
            ->all();


        foreach ($info as &$value) {
            $value['is_have'] = TeaInvoice::find()->where(['order_id' => $value['id'], 'type' => 1])->asArray()->one() ? 1 : 2;
            $value['start_time'] = date('Y-m-d H:i', strtotime($value['start_time']));

            //上一次订单结束时间
            $order_end_time = TeaOrderList::find()->where(['renew_order_id' => $value['id'], 'status' => [2, 3]])->orderBy('create_time DESC')->asArray()->one();
            if ($order_end_time && $order_end_time['end_time']) {
                $value['end_time'] = $order_end_time['end_time'];
            }
            //---------------------------

            $value['end_time'] = date('Y-m-d H:i', strtotime($value['end_time']));

            $value['nick_name'] = $member['nickName'];

            // 是否显示退款按钮
            $time = time();
            $start_time = DateHelper::dateToInt($value['start_time']);
            if ((int)$value['status'] == OrderStatus::status2 && $start_time - $time > 0 && $start_time - $time > 30 * 60) {
                $value['is_refund'] = 1;
            } else {
                $value['is_refund'] = 0;
            }

            $statusList = OrderStatus::listData();

            if (strtotime($value['start_time']) > $time) {
                $status = '待使用';
            } elseif (strtotime($value['end_time']) > $time) {
                $status = '使用中';
            } else {
                $status = '已过期';
            }

            $value['status'] = $value['status'] != 2 ? $statusList[$value['status']] : $status;
        }

        return $info;
    }

    public static function editMember($member_id, $data): int
    {
        return DdMember::updateAll($data, ['member_id' => $member_id]);
    }

    public static function integral($member_id): array
    {
        //积分明细
        $integral_addlist = AccountLog::find()
            ->where([
                'member_id' => $member_id,
                'is_add' => 0,
                'account_type' => [
                    'tea_member_give_integral',
                    'tea_member_give_inte_ren',
                    'tea_member_give_inte_cou',
                    'tea_member_give_inte_rec',
                ],
            ])
            ->select(['*', "FROM_UNIXTIME(create_time,'%Y-%m') as month"])
            ->orderBy(['create_time' => SORT_DESC])
            ->asArray()
            ->all();

        $month = [];
        foreach ($integral_addlist as &$val) {
            $val['old_money'] = round($val['old_money']);
            $val['money'] = round($val['money']);
            $val['surplus_integral'] = $val['old_money'] + $val['money'];
            $val['create_time'] = date('Y-m-d H:i:s', $val['create_time']);
            $month[$val['month']][] = $val;
        }

        $data = [];
        $a = 0;
        foreach ($month as $ke => $valu) {
            $data[$a]['time'] = $ke;
            $data[$a]['data'] = $valu;
            $a = $a + 1;
        }

        $user_integral = DdMemberAccount::find()
            ->select(['user_integral'])
            ->where(['member_id' => $member_id])
            ->asArray()
            ->one()['user_integral'];

        $list['integral'] = $data;
        $list['user_integral'] = $user_integral;
        //兑换明细

        return $list;
    }
}
