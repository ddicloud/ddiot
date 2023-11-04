<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 08:06:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-26 08:11:56
 */


namespace addons\diandi_integral;

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
  /**
   * @param $params
   * @return void
   * @throws \yii\base\InvalidConfigException
   * @throws \yii\web\NotFoundHttpException
   * @throws \yii\web\UnprocessableEntityHttpException
   */
  public function run($params): void
  {
    MigrateHelper::upByPath([
      '@addons/diandi_integral/migrations/'
    ]);
  }
}
