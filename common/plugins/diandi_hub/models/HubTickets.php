<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-18 17:50:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 17:42:34
 */


namespace common\plugins\diandi_hub\models;

use Yii;
use common\plugins\diandi_hub\models\enums\{
    TicketsType,
    TicketsStatus,
    TicketsRecordType,
};
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;

/**
 * This is the model class for table "{{%diandi_hub_tickets}}".
 *
 * @public int $id
 * @public int $bloc_id
 * @public int $store_id
 * @public int $user_id 会员ID
 * @public int $dev_id 开发者ID
 * @public string $topic 主题
 * @public int $type 类型
 * @public string $content 内容
 * @public int $status 状态
 */
class HubTickets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_tickets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'user_id', 'product_id', 'type', 'status', 'order_id'], 'integer'],
            [['user_id', 'topic', 'content', 'type'], 'required'],
            [['product_id'], 'required', 'when' => function () {
                return $this->type == TicketsType::SALES_INQUIRE;
            }],
            [['order_id'], 'required', 'when' => function () {
                return $this->type == TicketsType::BUG_FIXES || $this->type == TicketsType::OPERATE_INQUIRE;
            }],
            [['topic'], 'string', 'max' => 45],
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string', 'max' => 900],
            ['product_id', 'checkInquireId'],
            ['order_id', 'checkInquireId'],
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
                'updatedAttribute' => 'updated_at',
                'createdAttribute' => 'created_at',
                'storeAttribute' => '',
                'blocAttribute' => '',
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
            'id' => 'ID',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'order_id' => '订单ID',
            'user_id' => '会员ID',
            'product_id' => '产品ID',
            'topic' => '主题',
            'type' => '类型',
            'content' => '内容',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function checkInquireId($field, $scenario, $validator, $value)
    {
        switch ($this->type) {
            case TicketsType::BUG_FIXES:
            case TicketsType::OPERATE_INQUIRE:
                if ($field == 'order_id') {
                    $order = HubOrder::find()->where([
                        'user_id' => $this->user_id,
                        'order_id' => $value,
                    ])->select(['bloc_id', 'store_id', 'user_id', 'order_id'])->one();
                    if (!$order) {
                        $this->addError('order_id', '无效的订单ID');
                        return false;
                    } else {
                        $this->store_id = $order->store_id;
                        $this->bloc_id = $order->bloc_id;
                    }
                }
                break;

            case TicketsType::SALES_INQUIRE:
                if ($field == 'product_id') {
                    $goods = HubGoodsBaseGoods::find()->where([
                        'goods_id' => $value,
                    ])->select(['bloc_id', 'store_id', 'goods_id'])->one();
                    if (!$goods) {
                        $this->addError('product_id', '无效的产品ID！');
                        return false;
                    } else {
                        $this->store_id = $goods->store_id;
                        $this->bloc_id = $goods->bloc_id;
                    }
                }
                break;
        }
    }

    public function getOrder()
    {
        return $this->hasOne(HubOrder::class, ['order_id' => 'order_id']);
    }

    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class, ['goods_id' => 'product_id'])->select(['goods_id', 'goods_name', 'thumb', 'line_price']);
    }
}
