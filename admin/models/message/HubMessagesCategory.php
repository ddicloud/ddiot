<?php

/**
 * @Author: Radish <minradish@163.com>
 * @Date:   2022-10-09 15:34:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-05 20:16:30
 */
namespace admin\models\message;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_messages_category".
 *
 * @property int $id ID
 * @property int $bloc_id 企业ID
 * @property int $store_id 商户ID
 * @property int $pid 上级分类
 * @property string $name 分类名称
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class HubMessagesCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%messages_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'store_id', 'pid'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'pid', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
            ['pid', 'checkExist', 'when' => function () {
                return $this->pid > 0;
            }],
        ];
    }

    public function checkExist($field, $scenario, $validator, $value)
    {
        if ($this->id && $this->id == $value) {
            $this->addError('pid', '自己不能成为自己的上级！');
            return false;
        } else {
            $exists = self::find()->where(['id' => $value])->exists();
            if (!$exists) {
                $this->addError('pid', '无效的上级！');
                return false;
            }
        }
        return true;
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'updated_at',
                'createdAttribute' => 'created_at',
                'time_type' => 'datetime',
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
            'bloc_id' => '企业ID',
            'store_id' => '商户ID',
            'pid' => '上级分类',
            'name' => '分类名称',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(self::class, ['pid' => 'id']);
    }
}
