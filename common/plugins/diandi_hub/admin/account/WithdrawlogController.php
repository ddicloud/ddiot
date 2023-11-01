<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-23 14:38:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 18:06:06
 */


namespace common\plugins\diandi_hub\admin\account;

use admin\controllers\AController;
use common\helpers\DateHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;
use common\plugins\diandi_hub\models\account\HubWithdrawLog;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayStatus;
use common\plugins\diandi_hub\models\enums\WithdrawStatus;
use common\plugins\diandi_hub\models\enums\WithdrawTypeStatus;
use common\plugins\diandi_hub\models\Searchs\account\HubWithdrawLog as HubWithdrawLogSearch;
use common\plugins\diandi_hub\services\account\logAccount;
use common\plugins\diandi_hub\services\MemberService;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * WithdrawlogController implements the CRUD actions for HubWithdrawLog model.
 */
class WithdrawlogController extends AController
{
    public string $modelSearchName = "HubWithdrawLog";


    /**
     * Lists all HubWithdrawLog models.
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new HubWithdrawLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $lists['all'] = '全部';
        $list = WithdrawTypeStatus::listData();
        foreach ($list as $key => $value) {
            $lists[$key] = $value;
        }
        foreach ($lists as $key => $item) {
            $titles[] = $item;
            $urls[] = 'index';
            $options[] = ['HubWithdrawLog[withdraw_type]' => $key];
        }

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titles' => $titles,
            'urls' => $urls,
            'options' => $options,
        ]);
    }

    /**
     * Displays a single HubWithdrawLog model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {

        $lists['all'] = '全部';
        $list = WithdrawTypeStatus::listData();
        foreach ($list as $key => $value) {
            $lists[$key] = $value;
        }
        foreach ($lists as $key => $item) {
            $titles[] = $item;
            $urls[] = 'index';
            $options[] = ['HubWithdrawLog[withdraw_type]' => $key];
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
            'titles' => $titles,
            'urls' => $urls,
            'options' => $options,
        ]);
    }

    /**
     * Creates a new HubWithdrawLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new HubWithdrawLog();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }
    }

    /**
     * Updates an existing HubWithdrawLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     */
    public function actionUpdate($id): array
    {
        global $_GPC;
        $withdraw_status = Yii::$app->request->input('HubWithdrawLog')['withdraw_status'];


        $model = HubWithdrawLog::find()->where(['id' => $id])->with(['userbank', 'member'])->one();

        $old_withdraw_status = $model['withdraw_status'];
        $old_pay_status = $model['pay_status'];

        if ($model['withdraw_status'] == WithdrawStatus::getValueByName('驳回提现') || $model['withdraw_status'] == WithdrawStatus::getValueByName('已提现')) {

            Yii::$app->session->setFlash('error', "该订单已经处理完毕");


        } elseif ($withdraw_status == WithdrawStatus::getValueByName('已提现') && $old_withdraw_status == WithdrawStatus::getValueByName('申请提现')) {

            Yii::$app->session->setFlash('error', "请先审核或打款，然后确认");

            return $this->redirect(['index']);

        }


        $pay_type = $model->pay_type == 0 ? '支付宝' : '银行卡';

        $pay_no = $model->pay_type == 0 ? $model->userbank['alipay'] : $model->userbank['bank_no'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($withdraw_status == WithdrawStatus::getValueByName('驳回提现')) {

                MemberService::notAuditWithdraw($model->id);


            } elseif ($withdraw_status == WithdrawStatus::getValueByName('已提现')) {
                // 增加用户已提现

                if ($old_pay_status != PayStatus::getValueByName('已付款') && $old_pay_status != PayStatus::getValueByName('已退款')) {
                    $WithdrawTyp = $model->withdraw_type;


                    $change_type = AccountChangeStatus::getValueByName('提现打款');


                    $order_type = OrderTypeStatus::getValueByName('提现订单');


                    switch ($WithdrawTyp) {
                        case WithdrawTypeStatus::getValueByName('用户'):
                            $account_type = AccountTypeStatus::getValueByName('分享已提现');

                            $account_log_id = logAccount::addorderMoneyLog($model->member_id, 0, $model->money, 0, $change_type, $account_type, $order_type, 0, 0, 0, 0);


                            MemberService::updateAccountBymid($model->member_id, 'self_withdraw', $model->money, $account_log_id, '分享奖金提现打款');


                            break;
                        case WithdrawTypeStatus::getValueByName('团队'):
                            $account_type = AccountTypeStatus::getValueByName('团队已提现');

                            $account_log_id = logAccount::addorderMoneyLog($model->member_id, 0, $model->money, 0, $change_type, $account_type, $order_type, 0, 0, 0, 0);

                            MemberService::updateAccountBymid($model->member_id, 'team_withdraw', $model->money, $account_log_id, '团队奖金提现打款');

                            break;

                        case WithdrawTypeStatus::getValueByName('店铺'):
                            $account_type = AccountTypeStatus::getValueByName('店铺已提现');

                            $account_log_id = logAccount::addorderMoneyLog($model->member_id, 0, $model->money, 0, $change_type, $account_type, $order_type, 0, 0, 0, 0);

                            MemberService::updateAccountBymid($model->member_id, 'store_withdraw', $model->money, $account_log_id, '店铺奖金提现打款');

                            break;

                        case WithdrawTypeStatus::getValueByName('代理'):
                            $account_type = AccountTypeStatus::getValueByName('代理已提现');

                            $account_log_id = logAccount::addorderMoneyLog($model->member_id, 0, $model->money, 0, $change_type, $account_type, $order_type, 0, 0, 0, 0);

                            MemberService::updateAccountBymid($model->member_id, 'agent_withdraw', $model->money, $account_log_id, '代理奖金提现打款');

                            break;

                    }

                    HubWithdrawLog::updateAll([
                        'pay_status' => PayStatus::getValueByName('已付款')
                    ], [
                        'id' => $id
                    ]);

                }


            }


        }
        $lists['all'] = '全部';
        $list = WithdrawTypeStatus::listData();
        foreach ($list as $key => $value) {
            $lists[$key] = $value;
        }
        foreach ($lists as $key => $item) {
            $titles[] = $item;
            $urls[] = 'index';
            $options[] = ['HubWithdrawLog[withdraw_type]' => $key];
        }

        $WithdrawStatus = WithdrawStatus::listData();
        $WithdrawStatus[3] = '待打款';
        $WithdrawStatus[4] = '已打款';
        unset($WithdrawStatus[0]);
        $model->withdraw_status = $model->withdraw_status == 0 ? 2 : $model->withdraw_status;
        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'WithdrawStatus' => $WithdrawStatus,
            'pay_type' => $pay_type,
            'pay_no' => $pay_no,
            'titles' => $titles,
            'urls' => $urls,
            'options' => $options,
        ]);
    }

    /**
     * Deletes an existing HubWithdrawLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();
        return ResultHelper::json(200, '删除成功');
    }


    public function actionExportdatalist(): array
    {
        global $_GPC;

        $query = HubWithdrawLog::find()->with(['userbank', 'member']);
        $between_time = Yii::$app->request->input('between_time');

        $timeWhere = [];
        if (!empty($between_time[0])) {
            $start_time = DateHelper::dateToInt($between_time[0]);
            $end_time = DateHelper::dateToInt($between_time[1]);
            $timeWhere = ['between', 'create_time', $start_time, $end_time];
        }

        $list = $query->where($timeWhere)->all();


        if (!empty($list)) {

            $fileName = '提现日志' . date('Y-m-d H:i:s', time()) . '.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/withdrawlog/' . date('Y/m/d/', time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $list,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath' => $savePath,
                'columns' => [
                    'id',
                    'partner_trade_no',
                    'money_count',
                    'money',
                    [
                        'header' => '提现类型',
                        'format' => ['raw'],
                        'attribute' => 'withdraw_type',
                        'value' => function ($model) {
                            return WithdrawTypeStatus::getLabel($model->withdraw_type);
                        }
                    ],
                    [
                        'header' => '提现状态',
                        'format' => ['raw'],
                        'attribute' => 'withdraw_status',
                        'value' => function ($model) {
                            return WithdrawStatus::getLabel($model->withdraw_status);
                        }
                    ],
                    'member.username',
                    'userbank.name',
                    'userbank.mobile',
                    //'member_id',
                    //'confirm_name',
                    //'openid',
                    //'re_user_name',
                    //'desc',
                    //'ymd_time:datetime',
                    'create_time:datetime',
                    //'update_time:datetime',
                ]
            ]);

            return ResultHelper::json(200, '下载成功', [
                'url' => ImageHelper::tomedia('diandi_hub/excel/withdrawlog/' . date('Y/m/d/', time()) . $fileName)
            ]);
        } else {
            return ResultHelper::json(400, '没有可以下载的数据');
        }
    }


    /**
     * Finds the HubWithdrawLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|ActiveRecord
    {
        if (($model = HubWithdrawLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
