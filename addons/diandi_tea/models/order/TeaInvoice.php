<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-07 15:49:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-09 14:30:52
 */

namespace addons\diandi_tea\models\order;

/**
 * This is the model class for table "{{%diandi_tea_invoice}}".
 *
 * @public int         $id          人脸招聘
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null    $order_id    订单id
 * @public int|null    $status      是否开票: 1.已开  2.未开
 * @public string|null $invoice_url 发票文件地址
 * @public string|null $company     公司名称
 * @public string|null $social_code 社会统一代码
 * @public string|null $phone       电话
 * @public string|null $email       邮箱
 * @public int|null    $member_id   用户ID
 */
class TeaInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_invoice}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'order_id', 'status', 'member_id', 'type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['invoice_url'], 'string'],
            [['company', 'social_code', 'phone', 'email'], 'string', 'max' => 100],
            [['bank', 'bank_address', 'company_address', 'taxpayer_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
                'time_type' => 'datetime',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '人脸招聘',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'order_id' => '订单id',
            'status' => '是否开票: 1.已开  2.未开',
            'invoice_url' => '发票文件地址',
            'company' => '公司名称',
            'social_code' => '社会统一代码',
            'phone' => '电话',
            'email' => '邮箱',
            'member_id' => '用户ID',
            'type' => '发票类型1.订单发票 2.充值发票',
            'bank' => '银行账号',
            'bank_address' => '银行开户地',
            'company_address' => '公司地址',
            'taxpayer_no' => '纳税人识别号',
        ];
    }
}
