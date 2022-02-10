<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-14 08:56:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-13 10:20:55
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 **/
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/web/resource/';
    public $css = [
        // 'css/font-awesome.min.css',
        'css/style.css',
        'css/css-assets.css',
        // 'css/ionicons.min.css',
    ];

    public $js = [
        'js/jquery.js',
        'js/jRespond.min.js',
        'js/jquery.fitvids.js',
        'js/superfish.js',
        'scss/slick/slick.min.js',
        'js/jquery.magnific-popup.min.js',
        'js/scrollIt.min.js',
        'js/functions.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
