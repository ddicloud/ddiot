<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 08:06:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-26 08:12:04
 */

namespace addons\diandi_integral;


use yii\db\Migration;
use common\enums\AppEnum;
use common\models\rbac\AuthItemChild;
use common\models\rbac\AuthRole;
use common\models\common\ConfigValue;
use common\helpers\MigrateHelper;
use common\interfaces\AddonWidget;

/**
 * 卸载
 *
 * Class UnInstall
 * @package addons\Merchants
 */
class UnInstall extends Migration implements AddonWidget
{
    /**
     * @param $params
     * @return void
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function run($params): void
    {

        MigrateHelper::downByPath([
            '@addons/diandi_integral/migrations/'
            
        ]);
    }
}
