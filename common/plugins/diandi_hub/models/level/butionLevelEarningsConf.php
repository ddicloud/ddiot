<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-03 11:33:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:21:59
 */
 

namespace common\plugins\diandi_hub\models\level;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_level_earnings_conf}}".
 *
 * @public int $id
 * @public int $levelnum 当前等级
 * @public int|null $levelcnum 对应等级
 * @public int|null $levelc_num 对应人数
 * @public float|null $earnings 收益比例
 * @public int|null $condition 人数与销售额的关系
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class butionLevelEarningsConf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_level_earnings_conf}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['levelnum', 'levelcnum', 'levelc_num', 'condition', 'create_time', 'update_time'], 'integer'],
            [['earnings'], 'number','max'=>1],
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
                'is_bloc'=>1//集团数据

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
            'levelc_num' => '对应人数',
            'earnings' => '收益比例',
            'condition' => '人数与销售额的关系',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
