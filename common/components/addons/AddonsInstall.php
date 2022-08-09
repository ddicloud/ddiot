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
use yii\db\Migration;

/**
 * 安装.
 *
 * Class Install
 */
class AddonsInstall extends Migration implements AddonWidget
{
    public $addons = '';

    public function run($addon)
    {
        if (!empty($this->addons)) {
            $module_root = Yii::getAlias('@addons');
            $xml = file_get_contents($module_root.'/'.$this->addons.'/manifest.xml');
            $addonsXml = addonsService::ext_module_manifest_parse($xml);
            $version = $addonsXml['application']['version'];
            MigrateHelper::upByPath([
                '@addons/'.$this->addons.'/migrations/'.$version,
            ]);
        }
    }
}
