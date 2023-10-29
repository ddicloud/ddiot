<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 15:41:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 14:07:55
 */


namespace common\plugins\diandi_hub\models\goods;

use Yii;
use yii\helpers\ArrayHelper;

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
class HubCategory extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_category}}';
    }

    public $category_pid;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['parent_id','bloc_id','store_id','goods_id','sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name','image_id'], 'required'],
            ['sort', 'default', 'value' => 0],
            [['image_id'], 'string']

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



    public static function getRegion($parentId = 0)
    {
        $result = static::find()->where(['parent_id' => $parentId])->asArray()->all();
        return ArrayHelper::map($result, 'id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
