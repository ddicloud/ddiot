<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 05:42:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 11:28:04
 */
 

namespace common\plugins\diandi_hub\models\level;

use common\plugins\diandi_hub\models\goods\HubGift;
use common\plugins\diandi_outbound\models\enums\LevelStatus;
use Yii;

/**
 * This is the model class for table "dd_diandi_hub_level".
 *
 * @public int $id
 * @public int|null $bloc_id 公司ID
 * @public int|null $store_id 商户ID
 * @public string|null $levelname 等级名称
 * @public int|null $levelnum 等级
 * @public int|null $total_num 总人数
 * @public int|null $total_sale 总销售额
 * @public string|null $condition 条件汇总
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { 
        return '{{%diandi_hub_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'levelnum', 'total_num', 'total_sale',
            'level2_num',
            'level1_num',
            'level1_sale',
            'level2_sale',
            'self_sale',
             'create_time', 'update_time'], 'integer'],
            ["levelnum","in","range"=>LevelStatus::getConstantsByName()],
            [['levelname'], 'string','min'=>1, 'max' => 100],
            [['condition'], 'string', 'max' => 255],
            [['water_ratio'],'number']

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


    // 升级条件
    public function getCondition()
    {
        return $this->hasMany(DiandiHubLevelCondition::class,['levelnum'=>'levelnum']);
    }


     // 分销等级权益阶梯
     public function getBaseconf()
     {
         return $this->hasMany(HubLevelBaseConf::class,['levelnum'=>'levelnum']);
     }

     
      // 等级权益阶梯
    public function getEarningsconf()
    {
        return $this->hasMany(butionLevelEarningsConf::class,['levelnum'=>'levelnum']);
    }

    // 等级礼包
    public function getGift()
    {
        return $this->hasMany(HubGift::class,['level_num'=>'levelnum']);
    }
    

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'levelname' => '等级名称',
            'levelnum' => '等级',
            'total_num' => '总人数',
            'total_sale' => '总销售额',
            'condition' => '条件汇总',
            'water_ratio'=> '店铺流水分红',
            'level2_num'=> '分销二级人数',
            'level1_num'=> '分销一级人数',
            'level1_sale'=> '分销一级销售额',
            'level2_sale'=> '分销二级销售额',
            'self_sale'=>'自己消费',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
