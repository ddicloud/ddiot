<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-30 21:08:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-30 23:29:49
 */
 

namespace common\plugins\diandi_hub\models\express;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_express_log".
 *
 * @public int $id
 * @public string|null $Action 步骤编号
 * @public string|null $ShipperCode 编码
 * @public string|null $LogisticCode
 * @public string|null $Location 所在地
 * @public string|null $AcceptStation 处理详情
 * @public string|null $AcceptTime 处理时间
 * @public string|null $Remark 状态备注
 * @public string|null $EstimatedDeliveryTime 签收时间
 * @public int|null $State 快递状态
 * @public int|null $EBusinessID 用户id
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubExpressLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_express_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['State', 'EBusinessID', 'create_time', 'update_time','AcceptTime'], 'integer'],
            [['Action', 'ShipperCode', 'LogisticCode', 'AcceptStation'], 'string', 'max' => 255],
            [['Location', 'EstimatedDeliveryTime'], 'string', 'max' => 30],
            [['Remark'], 'string', 'max' => 30],
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
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Action' => 'Action',
            'ShipperCode' => 'Shipper Code',
            'LogisticCode' => 'Logistic Code',
            'Location' => 'Location',
            'AcceptStation' => 'Accept Station',
            'AcceptTime' => 'Accept Time',
            'Remark' => 'Remark',
            'EstimatedDeliveryTime' => 'Estimated Delivery Time',
            'State' => 'State',
            'EBusinessID' => 'E Business ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
