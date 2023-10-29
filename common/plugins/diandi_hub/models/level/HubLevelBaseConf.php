<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-03 11:28:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:21:22
 */
 

namespace common\plugins\diandi_hub\models\level;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_level_base_conf}}".
 *
 * @public int $id
 * @public int $levelnum 当前等级
 * @public int|null $levelcnum 发展等级
 * @public float|null $level1_radio 一级分销比例
 * @public float|null $level2_radio 二级分销比例
 * @public float|null $level3_radio 三级分销比例
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubLevelBaseConf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_level_base_conf}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['levelnum', 'levelcnum', 'create_time', 'update_time'], 'integer'],
            [['level1_radio', 'level2_radio', 'level3_radio'], 'number','max'=>1],
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
            'levelnum' => '当前等级',
            'levelcnum' => '发展等级',
            'level1_radio' => '一级分销比例',
            'level2_radio' => '二级分销比例',
            'level3_radio' => '三级分销比例',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
