<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 10:30:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 17:16:23
 */

namespace addons\diandi_tea;

use common\helpers\MigrateHelper;
use common\interfaces\AddonWidget;
use ErrorException;
use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * 卸载.
 *
 * Class UnInstall
 */
class UnInstall extends Migration implements AddonWidget
{
    public string $version = '1.0.0';

    /**
     * @throws ErrorException
     */
    public function run($params): void
    {
        try {
            MigrateHelper::downByPath([
                '@addons/diandi_tea/migrations/' . $this->version,
            ]);
        } catch (InvalidConfigException|NotFoundHttpException|UnprocessableEntityHttpException $e) {
            throw new ErrorException($e->getMessage());
        }
    }
}
