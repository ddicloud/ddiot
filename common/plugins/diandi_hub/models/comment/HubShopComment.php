<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-19 19:45:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 18:52:47
 */

namespace common\plugins\diandi_hub\models\comment;

use api\models\DdMember;
use common\models\DdUser;
use api\modules\wechat\models\DdWxappFans;

/**
 * This is the model class for table "dd_shop_comment".
 *
 * @public int         $id
 * @public int|null    $user_id     评论人
 * @public string|null $comment     评论内容
 * @public string|null $create_time 评论时间
 * @public int|null    $status      是否审核
 * @public int|null    $star_level  星级
 */
class HubShopComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_comment}}';
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
                'updatedAttribute' => 'create_time',
                'createdAttribute' => 'update_time',
            ],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!is_numeric($this->status) && isset($this->status)) {
                //字段
                $this->status = trim($this->status == '已审核') ? 1 : 0;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id','bloc_id','type','store_id', 'status', 'star_level', 'comment_id'], 'integer'],
            [['create_time'], 'string'],
            ['images','safe'],
            [['comment'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if(is_array($this->images))
            {
               //字段
                $this->images=serialize($this->images);
            }
            return true;
        }
        else
            return false;
    }

    /* 获取分类 */
    public function getUser()
    {
        return $this->hasOne(DdUser::class, ['id' => 'user_id'])->select(['id', 'mobile', 'company', 'username', 'email', 'parent_bloc_id', 'store_id', 'bloc_id', 'status', 'created_at', 'updated_at', 'last_time', 'avatar', 'is_login', 'last_login_ip', 'open_id', 'union_id']);
    }

    /* 获取分类 */
    public function getFans()
    {
        return $this->hasOne(DdWxappFans::class, ['user_id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '评论人',
            'comment_id'=>'评价内容ID',
            'type'=>'评价类型',
            'comment' => '评论内容',
            'create_time' => '评论时间',
            'status' => '是否审核',
            'star_level' => '星级',
        ];
    }
}
