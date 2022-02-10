<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 02:32:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:08:23
 */
use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => ['百度SDK'],
    'options' => [
        // 'plugins'=> $plugins
    ],
    'urls' => ['baidu'],
]); ?>