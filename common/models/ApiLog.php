<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%api_log}}".
 *
 * @public int $id
 * @public string $url
 * @public string $method
 * @public string $get_data
 * @public string $post_data
 * @public string $ip ip地址
 * @public int $append
 */
class ApiLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['get_data', 'post_data'], 'string'],
            [['append'], 'integer'],
            [['url'], 'string', 'max' => 1000],
            [['method'], 'string', 'max' => 20],
            [['ip'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => '提交类型',
            'url' => '提交的url',
            'get_data' => 'get数据',
            'post_data' => 'post数据',
            'ip' => 'IP地址',
            'append' => '创建时间',
        ];
    }

    /**
     * 日志记录
     *
     * @throws \yii\base\InvalidConfigException
     */
    public static function add()
    {
        $model = new self();
        $model->url = Yii::$app->request->getUrl();
        $model->get_data = json_encode(Yii::$app->request->get());
        $model->post_data = json_encode(Yii::$app->request->post());
        $model->method = Yii::$app->request->method;
        $model->ip = Yii::$app->request->userIP;
        $model->append = time();
        $model->save();
    }
}
