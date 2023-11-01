<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-02 03:47:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:03:59
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\services\account\logAccount;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\MemberService;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class AddressController.
 */
class AccountController extends AController
{
    public $modelClass = '\common\addons\diandi_hub\models\account\HubAccountLog';

    public int $searchLevel = 0;

    public array $authOptional = ['addlog'];

    // 获取我的资产日志
    public function actionLog(): array
   {

        $change_type = intval(Yii::$app->request->input('change_type'));
        $account_type = intval(Yii::$app->request->input('account_type'));

        $pageSize = !empty(Yii::$app->request->input('pageSize')) ?\Yii::$app->request->input('pageSize') : 10;

        $page = !empty(Yii::$app->request->input('page')) ?\Yii::$app->request->input('page') : 1;

        $member_id = Yii::$app->user->identity->user_id;
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

    public function actionOrder(): array
   {
        $user_id = Yii::$app->user->identity->user_id;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_type =\Yii::$app->request->input('order_type');
        $type =\Yii::$app->request->input('type'); //分佣类型0分销佣金1等级佣金2团队佣金3区域经理佣金
        $list = OrderAccount::list($order_type, $type, $user_id, $order_status, $pageSize);

        $order_type_str = OrderTypeStatus::getLabel($order_type);

        return ResultHelper::json(200, '获取成功', [
           'list' => $list,
           'order_type_str' => $order_type_str,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function actionWithdraw()
   {

        $member_id = Yii::$app->user->identity->user_id;

        $type =\Yii::$app->request->input('type');
        $pay_type =\Yii::$app->request->input('pay_type');
        $Res = MemberService::withdraw($member_id, $type, $pay_type);
        if ($Res['code'] == 0) {
            return ResultHelper::json(200, '提现成功');
        }

        if ($Res['code'] == 1) {
            return ResultHelper::json(400, $Res['msg']);
        }
    }

    public function actionAddlog(): array
   {

        $member_id =\Yii::$app->request->input('member_id');
        $order_id =\Yii::$app->request->input('order_id');
        $money =\Yii::$app->request->input('money');
        $order_goods_id =\Yii::$app->request->input('order_goods_id');
        $change_type =\Yii::$app->request->input('change_type');
        $account_type =\Yii::$app->request->input('account_type');
        $order_type =\Yii::$app->request->input('order_type');
        $goods_type =\Yii::$app->request->input('goods_type');
        $order_price =\Yii::$app->request->input('order_price');
        $goods_id =\Yii::$app->request->input('goods_id');
        $goods_price =\Yii::$app->request->input('goods_price');
        $performance =\Yii::$app->request->input('performance');

        $log_account_id = logAccount::addorderMoneyLog($member_id, $order_id, $money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

        return ResultHelper::json(200, '', ['log_account_id' => $log_account_id]);
    }
}
