<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-01 01:51:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-01 01:51:59
 */
 

namespace common\plugins\diandi_cloud;

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
  public function run($params)
  {
    MigrateHelper::upByPath([
      '@addons/diandi_cloud/migrations/'
    ]);
  }
}
