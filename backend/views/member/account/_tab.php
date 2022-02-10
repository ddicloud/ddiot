<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-05 00:05:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-05 00:06:02
 */
 

use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => [
            '管理',
            '详情',
            '更新',
    ],
    'urls'=>[
        'index',
        'view',
        'update'
    ]
]); ?>


