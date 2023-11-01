<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-28 14:46:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-04 19:08:00
 */

namespace addons\diandi_website\api;

use api\controllers\AController;
use Yii;

class ApiController extends AController
{
    public $modelClass = '';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'json-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@api/controllers'),
                    Yii::getAlias('@addons/diandi_website/api'),
                ],
                'cacheKey' => 'diandi_website-api',
            ],
            'admin-base' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@admin/controllers'),
                    Yii::getAlias('@addons/diandi_website/admin'),
                ],
                'cacheKey' => 'diandi_website-admin',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
