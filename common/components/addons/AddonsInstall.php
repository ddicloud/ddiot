<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-09 16:10:13
 */

namespace common\components\addons;

use common\helpers\MigrateHelper;
use common\interfaces\AddonWidget;
use diandi\addons\services\addonsService;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * 安装.
 *
 * Class Install
 */
class AddonsInstall extends Migration implements AddonWidget
{
    public string $addons = '';

    /**
     * @throws ErrorException
     */
    public function run($params): void
    {
        if (!empty($this->addons)) {
            $module_root = Yii::getAlias('@addons');
            $xml = file_get_contents($module_root.'/'.$this->addons.'/manifest.xml');
            $addonsXml = addonsService::ext_module_manifest_parse($xml);
            $version = $addonsXml['application']['version'];
            try {
                MigrateHelper::upByPath([
                    '@addons/' . $this->addons . '/migrations/' . $version,
                ]);
            } catch (InvalidConfigException|UnprocessableEntityHttpException|NotFoundHttpException $e) {
                throw new ErrorException($e->getMessage());
            }
        }
    }
}
