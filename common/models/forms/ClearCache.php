<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-17 14:09:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 18:04:51
 */

namespace common\models\forms;

use common\helpers\FileHelper;
use Yii;
use yii\base\Model;

class ClearCache extends Model
{
    /**
     * @var int
     */
    public $cache = 1;

    public $template = 1;

    /**
     * @var bool
     */
    protected $status = true;

    public function rules()
    {
        return [
            [['cache', 'template'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cache' => '数据缓存',
            'template' => '模板缓存',
        ];
    }

    public function save()
    {
        if ($this->cache == true) {
            $status = Yii::$app->cache->flush();
            !$status && $this->addError('cache', '数据缓存清理失败');
        }
        return $this->hasErrors() == false;
    }
}
