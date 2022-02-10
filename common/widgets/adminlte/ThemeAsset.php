<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-08 00:25:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-23 02:44:59
 */

namespace common\widgets\adminlte;


use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/asset/';
    
    public $css = [
        'dist/css/site.css',
    ];
    public $js = [
        // 'assets/99a51ff8/jquery-ui.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'common\widgets\adminlte\AdminLteAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
