<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 23:30:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 22:47:50
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "dd_wxapp_slide".
 *
 * @public int $id
 * @public string|null $images
 * @public string|null $background
 * @public string|null $url
 * @public string|null $createtime
 * @public string|null $updatetime
 */
class HubWxappSlide extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_wxapp_slide}}';
    }

      /**
     * 行为
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
           [
               'class'=>\common\behaviors\SaveBehavior::class,
               'updatedAttribute'=>'createtime',
               'createdAttribute'=>'updatetime',
           ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['createtime', 'updatetime'], 'safe'],
            [['images', 'background', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'images' => '图片',
            'background' => '背景色',
            'url' => '链接地址',
            'createtime' => '创建时间',
            'updatetime' => '更新时间',
        ];
    }
}
