<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-01 09:56:07
 */

namespace common\components\addons;

use common\helpers\MigrateHelper;
use common\interfaces\AddonWidget;
use diandi\addons\services\addonsService;
use Yii;
use yii\db\Migration;

/**
 * 卸载.
 *
 * Class AddonsUninstall
 */
class AddonsUninstall extends Migration implements AddonWidget
{
    public $addons = '';

    public function run($addon)
    {
        if (!empty($this->addons)) {
            $module_root = Yii::getAlias('@addons');
            $xml = file_get_contents($module_root.'/'.$this->addons.'/manifest.xml');
            $addonsXml = addonsService::ext_module_manifest_parse($xml);
            $version = $addonsXml['version'];
            MigrateHelper::downByPath([
                '@addons/'.$this->addons.'\\/migrations/'.$version,
            ]);
        }
    }
}
