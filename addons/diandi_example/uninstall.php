<?php

namespace addons\diandi_example;

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
    
    public function run($addon)
    {

        MigrateHelper::downByPath([
            '@addons/diandi_example/migrations/'
        ]);
    }
}
