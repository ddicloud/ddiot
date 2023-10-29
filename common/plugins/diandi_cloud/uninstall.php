<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-01 01:52:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-01 01:52:10
 */
 

namespace common\plugins\diandi_cloud;

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
    
    public function run($params)
    {

        MigrateHelper::downByPath([
            '@addons/diandi_cloud/migrations/'
        ]);
    }
}
