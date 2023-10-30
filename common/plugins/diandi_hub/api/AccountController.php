<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-02 03:47:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 15:47:27
 */

namespace common\plugins\diandi_hub\api;

use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\services\account\logAccount;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\MemberService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class AddressController.
 */
class AccountController extends AController
{
    public $modelClass = '\common\addons\diandi_hub\models\account\HubAccountLog';

    public array $authOptional = ['addlog'];

    // 获取我的资产日志
    public function actionLog()
    {
        global $_GPC;

        $change_type = intval($_GPC['change_type']);
        $account_type = intval($_GPC['account_type']);

        $pageSize = !empty($_GPC['pageSize']) ? $_GPC['pageSize'] : 10;

        $page = !empty($_GPC['page']) ? $_GPC['page'] : 1;

        $member_id = Yii::$app->user->identity->member_id??0;
        $list = logAccount::getListByMid($member_id, $change_type, $account_type, $pageSize, $page);

        $change_type_str = !empty($change_type) ? AccountChangeStatus::getLabel($change_type) : '资产明细';

        $account_type_str = !empty($account_type) ? AccountTypeStatus::getLabel($account_type) : '资产';

        return ResultHelper::json(200, '获取成功', [
                'list' => $list,
                'change_type' => $change_type,
                'account_type' => $account_type,
                'change_type_str' => $change_type_str,
                'account_type_str' => $account_type_str,
            ]);
    }

    public function actionOrder()
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->member_id??0;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_type = $_GPC['order_type'];
        $type = $_GPC['type']; //分佣类型0分销佣金1等级佣金2团队佣金3区域经理佣金
        $list = OrderAccount::list($order_type, $type, $user_id, $order_status, $pageSize);

        $order_type_str = OrderTypeStatus::getLabel($order_type);

        return ResultHelper::json(200, '获取成功', [
           'list' => $list,
           'order_type_str' => $order_type_str,
        ]);
    }

    public function actionWithdraw()
    {
        global $_GPC;

        $member_id = Yii::$app->user->identity->member_id??0;

        $type = $_GPC['type'];
        $pay_type = $_GPC['pay_type'];
        $Res = MemberService::withdraw($member_id, $type, $pay_type);
        if ($Res['code'] == 0) {
            return ResultHelper::json(200, '提现成功');
        }

        if ($Res['code'] == 1) {
            return ResultHelper::json(400, $Res['msg']);
        }
    }

    public function actionAddlog()
    {
        global $_GPC;

        $member_id = $_GPC['member_id'];
        $order_id = $_GPC['order_id'];
        $money = $_GPC['money'];
        $order_goods_id = $_GPC['order_goods_id'];
        $change_type = $_GPC['change_type'];
        $account_type = $_GPC['account_type'];
        $order_type = $_GPC['order_type'];
        $goods_type = $_GPC['goods_type'];
        $order_price = $_GPC['order_price'];
        $goods_id = $_GPC['goods_id'];
        $goods_price = $_GPC['goods_price'];
        $performance = $_GPC['performance'];

        $log_account_id = logAccount::addorderMoneyLog($member_id, $order_id, $money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

        return ResultHelper::json(200, '', ['log_account_id' => $log_account_id]);
    }
}