<?php

/**
 * @Author: Radish <minradish@163.com>
 * @Date:   2022-10-09 15:34:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-05 20:35:53
 */

namespace admin\models\message;

use Codeception\Lib\Console\Message;
use common\models\DdUser;
use Yii;

/**
 * This is the model class for table "dd_messages".
 *
 * @property int $id ID
 * @property int $bloc_id 企业ID
 * @property int $store_id 商户ID
 * @property int $category_id 分类ID
 * @property string $title 标题
 * @property string $content 内容
 * @property string $admin_ids 接收者IDS
 * @property string $publish_at 发布时间
 * @property int $view 查看次数
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class HubMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%messages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'store_id', 'category_id', 'view', 'status'], 'integer'],
            [['category_id', 'title', 'content', 'publish_at'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['admin_ids'], 'string', 'max' => 450],
            ['admin_ids', 'checkAdminIds'],
            [['publish_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['category_id', 'exist', 'targetClass' => 'admin\models\message\HubMessagesCategory', 'targetAttribute' => 'id', 'message' => '指定分类不存在！'],
        ];
    }

    public function checkAdminIds($field, $scenario, $validator, $value)
    {
        $ids = explode(',', $value);
        if ($ids) {
            $data = DdUser::find()->where(['id' => $ids])->select('id')->asArray()->all();
            sort($ids);
            $dataIds = array_column($data, 'id');
            sort($dataIds);
            if ($dataIds != $ids) {
                $this->addError('admin_ids', '无效的管理员ID:' . implode(',', array_diff($ids, $dataIds)));
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
            'category_id' => '分类ID',
            'title' => '标题',
            'content' => '内容',
            'admin_ids' => '接收者IDS',
            'publish_at' => '发布时间',
            'view' => '查看次数',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getCurrentUserRead()
    {
        return $this->hasOne(HubMessagesRead::class, ['message_id' => 'id'])->where(['admin_id' => \Yii::$app->user->identity->user_id]);
    }

    /**
     * 统计管理员未读数
     * @date 2022-10-11 周二
     * @author Radish <minradish@163.com>
     * @param int $adminId 管理员ID
     * @return int
     */
    public static function countUnread($adminId)
    {
        $blocId = \Yii::$app->params['bloc_id'];
        $storeId = \Yii::$app->params['store_id'];
        $sql = <<<SQL
        SELECT
            count( 1 ) as num
        FROM
            `dd_messages`
            LEFT JOIN ( SELECT * FROM `dd_messages_read` WHERE admin_id = {$adminId} ) AS b ON b.message_id = dd_messages.id
        WHERE
            ( dd_messages.admin_ids = '' OR find_in_set( {$adminId}, dd_messages.admin_ids ) )
            AND
            b.id IS NULL
            AND
            dd_messages.bloc_id = {$blocId}
            AND
            dd_messages.store_id = {$storeId}
SQL;
        $count = Yii::$app->getDb()->createCommand($sql)->queryOne();
        $count = $count['num'] ?? 0;
        return $count;
    }
}
