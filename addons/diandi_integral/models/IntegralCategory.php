<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 15:41:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-28 16:58:02
 */


namespace addons\diandi_integral\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "dd_category".
 *
 * @public int $category_id
 * @public string $name 分类名称
 * @public int $parent_id
 * @public int $image_id
 * @public int $sort
 * @public int $wxapp_id
 * @public int $create_time
 * @public int $update_time
 */
class IntegralCategory extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public array $imageFiles = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_category}}';
    }

    public int $category_pid = 0;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['parent_id','bloc_id','store_id','goods_id','sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
            ['sort', 'default', 'value' => 0],
            [['image_id'], 'string']

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
                'is_bloc'=>true,
            ],
        ];
    }



    public static function getRegion($parentId = 0): array
    {
        $result = static::find()->where(['parent_id' => $parentId])->asArray()->all();
        return ArrayHelper::map($result, 'id', 'name');
    }


    public function getName2(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralCategory::class,['category_id' => 'parent_id'])->select(['name AS parent_name','category_id'])->asArray();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'category_id' => '分类id',
            'name' => '分类名称',
            'goods_id'=>'商品id',
            'parent_id' => '父级id',
            'image_id' => '图片',
            'sort' => '排序',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
