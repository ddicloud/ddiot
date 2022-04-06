<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 08:56:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-23 11:24:33
 */

/***
 * @开源软件: 店滴AI-基于AI的软硬件开源解决方案
 * @官方地址: http://www.wayfirer.com/
 * @版本: 1.0
 * @邮箱: 2192138785@qq.com
 * @作者: Wang Chunsheng
 * @Date: 2020-02-28 22:38:40
 * @LastEditTime: 2020-04-25 18:05:07
 */

namespace addons\diandi_ai\models\forms;

use addons\diandi_ai\models\BaiduConfig;
use common\helpers\StringHelper;
use Yii;
use yii\base\Model;

class Baidu extends Model
{
    /**
     * @var string application name
     */
    public $id;
    public $APP_ID;
    public $name;

    /**
     * @var string admin email
     */
    public $API_KEY;
    public $bloc_id;

    /**
     * @var string
     */
    public $SECRET_KEY;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['APP_ID', 'API_KEY', 'SECRET_KEY', 'name'], 'string'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BaiduConfig();
        $store = $conf::findOne(['bloc_id' => $bloc_id]);
        if (!empty($store)) {
            $this->id = $store->id;

            $this->bloc_id = $store->bloc_id;
            $this->APP_ID = StringHelper::hideStr($store->APP_ID, 2);
            $this->API_KEY = StringHelper::hideStr($store->API_KEY, 2);
            $this->SECRET_KEY = StringHelper::hideStr($store->SECRET_KEY, 4, 20);
            $this->name = StringHelper::hideStr($store->name, 4, 20);
        }
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = BaiduConfig::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new BaiduConfig();
        }

        $conf->bloc_id = $bloc_id;
        $conf->APP_ID = $this->APP_ID;
        $conf->API_KEY = $this->API_KEY;
        $conf->SECRET_KEY = $this->SECRET_KEY;
        $conf->name = $this->name;

        return $conf->save();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'APP_ID' => Yii::t('app', 'APP_ID'),
            'API_KEY' => Yii::t('app', 'API_KEY'),
            'SECRET_KEY' => Yii::t('app', 'SECRET_KEY'),
            'name' => '应用名称',
        ];
    }
}
