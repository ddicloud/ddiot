<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-06-24 10:54:33
 */
echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace(); ?>;

use common\components\addons\PluginsModule;

/**
* diandi_dingzuo module definition class.
*/
class admin extends PluginsModule
{
/**
* {@inheritdoc}
*/
public $controllerNamespace = "<?= $generator->getControllerNamespace() . '\\admin'; ?>";

/**
* {@inheritdoc}
*/
public function init(): void
{
parent::init();
}
}