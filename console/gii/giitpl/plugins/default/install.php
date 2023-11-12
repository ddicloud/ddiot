<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-08 16:36:25
 */
echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace(); ?>;

use common\components\addons\AddonsInstall;

/**
 * 安装.
 *
 * Class Install
 */
class Install extends AddonsInstall
{
    public $addons = '<?= $generator->moduleID; ?>';
}
