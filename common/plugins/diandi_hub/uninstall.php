<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-23 15:28:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-18 18:08:09
 */

namespace common\plugins\diandi_hub;

use common\components\addons\AddonsUninstall;

/**
 * 卸载.
 *
 * Class UnInstall
 */
class UnInstall extends AddonsUninstall
{
    public string $addons = 'diandi_hub';
}
