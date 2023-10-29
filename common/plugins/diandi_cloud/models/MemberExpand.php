<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-20 09:52:22
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-20 17:00:29
 */

namespace common\plugins\diandi_cloud\models;

use Yii;
use common\plugins\diandi_cloud\services\MemberService;
use api\modules\wechat\controllers\BasicsController;
use common\plugins\diandi_cloud\models\enums\{
    MemberCertStatus,
    MemberCertType,
    MemberIsDeveloper,
    MemberCertGoldStatus,
};

/**
 * This is the model class for table "{{%member_expand}}".
 *
 * @public int $member_id 会员ID
 * @public int $is_developer 是否是开发者
 * @public float $cert_gold 认证金
 * @public int $cert_type 认证类型
 * @public int $admin_id 管理员ID
 * @public int $cert_status 认证状态
 * @public string $created_at 创建时间
 */
class MemberExpand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member_expand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        $temp = MemberCertType::$list;
        unset($temp[MemberCertType::NOT]);
        return [
            [['member_id'], 'required'],
            [['member_id', 'is_developer', 'cert_type', 'admin_id', 'cert_status'], 'integer'],
            [['cert_gold'], 'number'],
            [['created_at', 'cert_gold_status', 'pay_at', 'pay_no', 'id_card_front', 'id_card_reverse', 'id_card_expired_at', 'license', 'audit_type', 'audit_opinion'], 'safe'],
            [['member_id'], 'unique'],
            [['audit_type', 'id_card_front', 'id_card_reverse', 'id_card_expired_at'], 'required'],
            [['license'], 'required', 'when' => function () {
                return $this->audit_type == MemberCertType::ENTERPRISE;
            }],
            ['audit_type', 'in', 'range' => array_keys($temp), 'message' => '认证类型只能是:' . implode(',', array_keys($temp))]
        ];
    }

    public function scenarios()
    {
        return [
            'submit_audit' => ['audit_type', 'id_card_front', 'id_card_reverse', 'id_card_expired_at', 'license'],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                // 'updatedAttribute' => 'update_time',
                'createdAttribute' => 'created_at',
                'adminAttribute' => '',
                'time_type' => 'datetime',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'member_id' => '会员ID',
            'admin_id' => '管理员ID',
            'is_developer' => '是否是开发者',
            'cert_gold' => '认证金',
            'cert_gold_status' => '认证金支付状态',
            'pay_at' => '支付时间',
            'pay_no' => '认证金支付单号',
            'cert_type' => '认证类型（审核通过）',
            'cert_status' => '认证状态',
            'id_card_front' => '身份证正面照',
            'id_card_reverse' => '身份证反面照',
            'id_card_expired_at' => '身份证件过期时间',
            'license' => '营业执照照片',
            'audit' => '（个人或者企业信息）审核状态',
            'audit_type' => '待审核认证类型',
            'audit_opinion' => '审核意见',
            'created_at' => '创建时间',
        ];
    }

    public function getMember()
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id'])->select(DdMember::SELECT_FIELD);
    }

    /**
     * 微信支付
     * @date 2022-08-03
     * @author Radish
     */
    public function wechatPay()
    {
        try {
            $member = self::find()->where('member_id = ' . $this->member_id)->one();
            $corePaylog = MemberService::createPayLog($member);
            if ($corePaylog === false) {
                $this->addError('pay_type', '创建支付信息失败');
                return false;
            } else {
                $data = [
                    'openid' => $corePaylog['openid'],
                    'spbill_create_ip' => Yii::$app->request->userIP,
                    'body' => '开发者认证金', // 内容
                    'out_trade_no' => $member->pay_no, // 订单号
                    'total_fee' => $member->cert_gold,
                    'trade_type' => 'JSAPI', //支付类型
                ];
                \Yii::$app->request->setBodyParams($data);
                $res = (new BasicsController('basics', Yii::$app->module))->actionPayparameters();
                if ($res['code'] == 200) {
                    return ['pay_type' => 'JSAPI', 'data' => $res['data']];
                } else {
                    $msg = $res['message'] ?? '';
                    if (!$msg) {
                        $msg = $res['data']['return_msg'] ?? '';
                    }
                    $this->addError('pay_type', $msg ?: '未知错误！');
                    return false;
                }
            }
        } catch (\Exception $e) {
            $this->addError('temp_address', $e->getMessage());
            return false;
        }
    }

    public function paySuccess()
    {
        $this->cert_gold_status = MemberCertGoldStatus::VALID;
        $this->pay_at = date('Y-m-d H:i:s');
    }
}
