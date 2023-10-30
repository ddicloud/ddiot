<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-08 23:59:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 16:00:00
 */

namespace common\plugins\diandi_hub\models\express;

/**
 * This is the model class for table "{{%diandi_hub_express_template}}".
 *
 * @public int         $id
 * @public string|null $title         模板名称
 * @public int|null    $express_id    快递id
 * @public int|null    $bynum_snum    首件
 * @public int|null    $bynum_sprice  首件运费
 * @public int|null    $bynum_xnum    续件
 * @public int|null    $bynum_xprice  续件费用
 * @public int|null    $bynum_is_use  是否计件收费
 * @public int|null    $weight_snum   首重
 * @public int|null    $weight_sprice 首重费用
 * @public int|null    $weight_xnum   续重
 * @public int|null    $weight_xprice 续重费用
 * @public int|null    $weight_is_use 是否计重收费
 * @public int|null    $volume_snum   首体积量
 * @public int|null    $volume_sprice 首体积运费
 * @public int|null    $volume_xnum   续体积
 * @public int|null    $volume_xprice 续体积运费
 * @public int|null    $volume_is_use 是否计体积收费
 * @public int|null    $create_time
 * @public int|null    $update_time
 */
class HubExpressTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_express_template}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['express_id', 'bynum_snum', 'bynum_sprice', 'bynum_xnum', 'bynum_xprice', 'bynum_is_use', 'weight_snum', 'weight_sprice', 'weight_xnum', 'weight_xprice', 'weight_is_use', 'volume_snum', 'volume_sprice', 'volume_xnum', 'volume_xprice', 'volume_is_use', 'create_time', 'update_time', 'is_default'], 'integer'],
            [['bynum_snum', 'bynum_sprice', 'bynum_xnum', 'bynum_xprice', 'weight_snum', 'weight_sprice', 'weight_xnum', 'weight_xprice',  'volume_snum', 'volume_sprice', 'volume_xnum', 'volume_xprice'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!is_numeric($this->is_default) && isset($this->is_default)) {
                //字段
                $list = ['非默认' => 0, '默认' => 1];
                $this->updateAll(['is_default' => 0]);
                $this->is_default = $list[$this->is_default];
            }

            // if(is_array($this->images)){
            //     $this->images = serialize($this->images);

            // }

            return true;
        } else {
            return false;
        }
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

    public function getExpress()
    {
        return $this->hasOne(HubExpressCompany::class, ['id' => 'express_id']);
    }

    public function getArea()
    {
        return $this->hasOne(HubExpressTemplateArea::class, ['template_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '模板名称',
            'express_id' => '快递id',
            'bynum_snum' => '首件',
            'bynum_sprice' => '首件运费',
            'bynum_xnum' => '续件',
            'bynum_xprice' => '续件费用',
            'bynum_is_use' => '是否计件收费',
            'weight_snum' => '首重',
            'weight_sprice' => '首重费用',
            'weight_xnum' => '续重',
            'weight_xprice' => '续重费用',
            'weight_is_use' => '是否计重收费',
            'volume_snum' => '首体积量',
            'volume_sprice' => '首体积运费',
            'volume_xnum' => '续体积',
            'volume_xprice' => '续体积运费',
            'volume_is_use' => '是否计体积收费',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'is_default' => '是否默认',
        ];
    }
}