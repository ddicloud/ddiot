<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 00:35:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-02 18:12:56
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_slide}}".
 *
 * @public int $id
 * @public string|null $thumb 图片
 * @public int|null $store_id 商户id
 * @public int|null $bloc_id 公司id
 * @public string|null $title 名称
 * @public int|null $update_time
 * @public int|null $create_time
 */
class HubSlide extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_slide}}';
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
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'update_time', 'create_time','goods_id','terminal_type','displayorder'], 'integer'],
            [['thumb', 'title','url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb' => '图片',
            'store_id' => '商户id',
            'bloc_id' => '公司id',
            'title' => '名称',
            'goods_id' => '商品ID',
            'url' => '链接地址',
            'displayorder'=>'排序',
            'terminal_type' => '终端类型',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
}
