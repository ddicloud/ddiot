<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-15 Thursday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-20 10:40:44
 */

namespace common\plugins\diandi_cloud\api;

use Yii;
use api\controllers\AController;
use common\helpers\ResultHelper;
use common\plugins\diandi_cloud\services\MemberService;


class MemberController extends AController
{
    public $modelClass = '';

    use \addons\diandi_cloud\components\ResultTrait;

    public function actionRegisterDeveloper()
    {
        $data = Yii::$app->request->post();
        return MemberService::registerDeveloper($data);
    }

    public function actionPay()
    {
        $where = [
            'member_id' => \Yii::$app->user->identity->member_id,
        ];
        list($bool, $model) = MemberService::pay($where, \Yii::$app->request->post('pay_type', 0));
        if ($bool) {
            return $this->_json($model, '获取支付信息成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }

    public function actionSubmitAudit()
    {
        $where = [
            'member_id' => \Yii::$app->user->identity->member_id,
        ];
        $data = Yii::$app->request->post();
        list($bool, $model) = MemberService::submitAudit($where, $data);
        if ($bool === false) {
            return $this->_jsonError(current($model->getFirstErrors()) ?: '未知错误！', $model->getErrors());
        } else {
            return $this->_json($model, '提交审核成功！');
        }
    }

    public function actionDetail()
    {
        $where = [
            'member_id' => \Yii::$app->user->identity->member_id,
        ];
        return $this->_json(MemberService::detail($where));
    }
}
