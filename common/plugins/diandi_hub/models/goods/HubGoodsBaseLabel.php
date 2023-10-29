<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-29 20:31:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 14:27:00
 */

namespace common\plugins\diandi_hub\models\goods;

use Yii;

/**
 * This is the model class for table "diandi_hub_goods_label".
 *
 * @public int         $id
 * @public string|null $label 商品标签
 * @public string|null $color 标签颜色
 */
class HubGoodsBaseLabel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_basegoods_label}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['label'], 'string', 'max' => 4],
            [['color'], 'string', 'max' => 10],
            [['bloc_id', 'store_id'], 'integer'],
            [['thumb'], 'string', 'max' => 255],
            [['label', 'color'], 'required'],
            [['label', 'bloc_id', 'store_id'], 'verifyLabel'],
        ];
    }

    public function verifyLabel($attribute, $params)
    {
        if ($this->label) {
            $bloc_id = Yii::$app->service->commonGlobalsService->getBloc_id();
            $store_id = Yii::$app->service->commonGlobalsService->getStore_id();

            $where = [
                'label' => $this->label,
                'bloc_id' => $bloc_id,
                'store_id' => $store_id,
            ];
            $list = $this->find()->where($where)->exists();

            if ($list && !$this->id) {
                $this->addError($attribute, '标签值不能重复添加');
            }
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
            'label' => '标签名称',
            'color' => '标签颜色',
            'thumb' => '角标图片',
        ];
    }
}
