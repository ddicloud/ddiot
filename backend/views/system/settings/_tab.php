<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 02:32:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-10 20:55:22
 */
use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => ['域名设置', '百度SDK参数', '小程序设置', '公众号设置', '微信支付', '短信设置', '邮箱服务器', '地图设置', '远程附件'],
    'options' => [
        // 'plugins'=> $plugins
    ],
    'urls' => ['weburl', 'baidu', 'wxapp', 'wechat', 'wechatpay', 'sms', 'email', 'map', 'cloudoss'],
]); ?>