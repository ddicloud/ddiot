<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:51:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-11 17:08:37
 */
 

namespace common\models;

use Yii;

/**
 * This is the model class for table "dd_ai_sms_log".
 *
 * @public int $id
 * @public int|null $member_id 用户id
 * @public string|null $mobile 手机号码
 * @public string|null $code 验证码
 * @public string|null $content 内容
 * @public int|null $error_code 报错code
 * @public string|null $error_msg 报错信息
 * @public string|null $error_data 报错日志
 * @public string|null $usage 用途
 * @public int|null $used 是否使用[0:未使用;1:已使用]
 * @public int|null $use_time 使用时间
 * @public string|null $ip ip地址
 * @public int $status 状态(-1:已删除,0:禁用,1:正常)
 * @public int|null $created_at 创建时间
 * @public int|null $updated_at 修改时间
 */
class DdAiSmsLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ai_sms_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_id', 'error_code', 'used', 'use_time', 'status', 'created_at', 'updated_at','code','ip'], 'integer'],
            [['error_data'], 'string'],
            [['mobile', 'usage'], 'string', 'max' => 20],
            [['content'], 'string', 'max' => 500],
            [['error_msg'], 'string', 'max' => 200]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'mobile' => 'Mobile',
            'code' => 'Code',
            'content' => 'Content',
            'error_code' => 'Error Code',
            'error_msg' => 'Error Msg',
            'error_data' => 'Error Data',
            'usage' => 'Usage',
            'used' => 'Used',
            'use_time' => 'Use Time',
            'ip' => 'Ip',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
