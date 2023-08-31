<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:57:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-29 01:57:26
 */
 

namespace common\models;

use Yii;

/**
 * This is the model class for table "dd_message_notice_log".
 *
 * @public int $id
 * @public int|null $bloc_id 公司id
 * @public int|null $store_id 商户id
 * @public string $message 消息内容
 * @public int $is_read 是否阅读
 * @public int $user_id 用户
 * @public string $sign
 * @public int $type 消息类型
 * @public int|null $status 消息状态
 * @public int $create_time
 * @public int $end_time
 * @public string $url 链接地址
 */
class MessageNoticeLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%message_notice_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'store_id', 'is_read', 'user_id', 'type', 'status', 'create_time', 'end_time'], 'integer'],
            [['message', 'is_read', 'user_id', 'sign', 'type', 'create_time', 'end_time', 'url'], 'required'],
            [['message', 'url'], 'string', 'max' => 255],
            [['sign'], 'string', 'max' => 22],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司id',
            'store_id' => '商户id',
            'message' => '消息内容',
            'is_read' => '是否阅读',
            'user_id' => '用户',
            'sign' => 'Sign',
            'type' => '消息类型',
            'status' => '消息状态',
            'create_time' => 'Create Time',
            'end_time' => 'End Time',
            'url' => '链接地址',
        ];
    }
}
