<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:38:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-12-26 11:56:47
 */

namespace addons\diandi_integral\models;

use addons\diandi_integral\models\enums\GoodsStatus;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "dd_goods".
 *
 * @public int    $goods_id
 * @public string $goods_name
 * @public int    $category_id
 * @public int    $spec_type
 * @public int    $deduct_stock_type
 * @public string $content
 * @public int    $sales_initial
 * @public int    $sales_actual
 * @public int    $goods_sort
 * @public int    $delivery_id
 * @public int    $goods_status
 * @public int    $is_delete
 * @public int    $wxapp_id
 * @public int    $create_time
 * @public int    $update_time
 */
class IntegralGoods extends \yii\db\ActiveRecord
{
    public string $spec_item_thumb = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_goods}}';
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
            ],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            if (!is_numeric($this->goods_status) && isset($this->goods_status)) {
                //字段
                $this->goods_status = GoodsStatus::getValueByName($this->goods_status);
                if (empty($this->volume)) {
                    $this->volume = 0;
                }
                if (empty($this->express_template_id)) {
                    $this->express_template_id = 0;
                }
                if (empty($this->express_type)) {
                    $this->express_type = 0;
                }
            }

            // if(is_array($this->images)){
            //     $this->images = serialize($this->images);

            // }

            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->images)) {
                //字段
                $this->images = serialize($this->images);
            }

            if (empty($this->goods_sort)) {
                $this->goods_sort = 0;
            }

            return true;
        } else {
            return false;
        }
    }

    public function getSpecItemThumb(): string
    {
        return $this->spec_item_thumb;
    }

    public function setSpecItemThumb($spec_item_thumb): void
    {
        $this->spec_item_thumb = $spec_item_thumb;
    }


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['category_id', 'spec_type', 'deduct_stock_type', 'sales_initial', 'sales_actual', 'goods_sort', 'goods_integral', 'delivery_id', 'goods_status', 'create_time', 'update_time', 'bloc_id', 'store_id', 'express_type', 'express_template_id'], 'integer'],
            [['content', 'images', 'thumb', 'goods_name', 'category_id', 'sales_initial', 'sales_actual', 'category_pid', 'stock', 'goods_weight', 'deduct_stock_type'], 'required'],
            ['goods_sort', 'default', 'value' => 0],
            [['content'], 'compare', 'compareValue' => '', 'operator' => '!='],
            [['goods_name', 'label','video'], 'string', 'max' => 255],
            [['deduct_stock_type'], 'compare', 'compareValue' => '', 'operator' => '!='],
            ['stock', 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['goods_price', 'goods_money', 'browse', 'goods_weight', 'delivery_id', 'volume', 'line_price'], 'number'],
            [['category_id'], 'compare', 'compareValue' => 0, 'operator' => '!='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',

            'category_id' => '分类',
            'label' => '商品标签',
            'spec_type' => '商品规格',
            'goods_weight' => '重量(克)',
            'deduct_stock_type' => '库存计算方式',
            'content' => '商品介绍',
            'sales_initial' => '初始兑换量',
            'goods_sort' => '商品排序',
            'delivery_id' => '运费模板',
            'goods_status' => '是否上架',
            'is_delete' => '是否删除',
            'create_time' => '添加时间',
            'update_time' => '更新时间',
            'images' => '商品相册',
            'thumb' => '商品主图',
            'sales_actual' => '实际兑换量',
            'goods_integral' => '兑换积分',
            'browse' => '浏览量',
            'volume' => '体积',
            'express_type' => '运费计算方式',
            'express_template_id' => '快递模板',
            'goods_price' => '销售价格',
            'stock' => '库存',
            'spec_item_thumb' => '属性图片',
            'line_price' => '市场价格',
        ];
    }

    /* 获取分类 */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralCategory::class, ['category_id' => 'category_id']);
    }

    /**
     * 获取商品规格.
     *
     * @return ActiveQuery
     *
     */
    public function getSpec(): \yii\db\ActiveQuery
    {
        return $this->hasMany(IntegralSpec::class, ['goods_id' => 'goods_id']);
    }

    public function getDelivery(): ActiveQuery
    {
        return $this->hasMany(IntegralDelivery::class, ['delivery_id' => 'delivery_id'])->select(['name', 'delivery_id'])->asArray();
    }

    /**
     * 获取商品规格.
     *
     * @return ActiveQuery
     */
    public function getGoodsSpec(): ActiveQuery
    {
        return $this->hasMany(IntegralGoodsSpec::class, ['goods_id' => 'goods_id']);
    }

    /**
     * 获取属性关联关系.
     *
     * @return ActiveQuery
     */
    public function getSpecRel(): ActiveQuery
    {
        return $this->hasMany(IntegralGoodsSpecRel::class, ['goods_id' => 'goods_id']);
    }
}
