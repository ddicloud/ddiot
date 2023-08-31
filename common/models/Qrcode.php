<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:06:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-28 14:02:39
 */

namespace common\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%qrcode}}".
 *
 * @public int      $id
 * @public int      $store_id
 * @public int|null $bloc_id
 * @public string   $type
 * @public int      $extra
 * @public int      $qrcid
 * @public string   $scene_str
 * @public string   $name
 * @public string   $keyword
 * @public int      $model
 * @public string   $ticket
 * @public string   $url
 * @public int      $expire
 * @public int      $subnum
 * @public int|null $update_time
 * @public int      $create_time
 * @public int      $status
 */
class Qrcode extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * 临时.
     */
    const MODEL_TEM = 1;

    /**
     * 永久.
     */
    const MODEL_PERPETUAL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%qrcode}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['type', 'extra', 'qrcid', 'scene_str', 'name', 'keyword', 'model', 'ticket', 'url', 'expire', 'subnum', 'create_time', 'status'], 'required'],
            [['store_id', 'bloc_id', 'extra', 'qrcid', 'model', 'expire', 'subnum', 'update_time', 'create_time', 'status'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [['scene_str'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 50],
            [['keyword'], 'string', 'max' => 100],
            [['ticket'], 'string', 'max' => 250],
            [['url'], 'string', 'max' => 256],
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
                'class' => \common\behaviors\SaveBehavior::className(),
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
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'type' => 'Type',
            'extra' => 'Extra',
            'qrcid' => 'Qrcid',
            'scene_str' => 'Scene Str',
            'name' => 'Name',
            'keyword' => 'Keyword',
            'model' => 'Model',
            'ticket' => 'Ticket',
            'url' => 'Url',
            'expire' => 'Expire',
            'subnum' => 'Subnum',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }
}
