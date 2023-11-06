<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-01 09:57:54
 */

namespace common\plugins\diandi_website;

use common\components\addons\AddonsUninstall;

/**
 * 卸载.
 *
 * Class UnInstall
 */
class UnInstall extends AddonsUninstall
{
    public string $addons = 'diandi_website';
}
