<?php

namespace addons\diandi_example;

use Yii;
use yii\db\Migration;
use common\helpers\MigrateHelper;
use common\interfaces\AddonWidget;

/**
 * 安装
 *
 * Class Install
 * @package addons\Merchants
 */
class Install extends Migration implements AddonWidget
{
  public function run($addon)
  {
    MigrateHelper::upByPath([
      '@addons/diandi_example/migrations/'
    ]);
  }
}
