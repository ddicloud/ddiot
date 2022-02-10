<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-03 12:29:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-03 03:46:26
 */

namespace common\widgets\firevue;

use common\widgets\adminlte\ThemeAsset;
use Exception;
use Yii;
use yii\web\AssetBundle;

/**
 * Class VueJsAsset.
 */
class VuemainAsset extends AssetBundle
{
    public $sourcePath = '@vue/';

    public $css = [
        // 'element-ui/lib/theme-chalk/index.css',
    ];

    public $js = [
        // 'main.js',
        'app/utli/init.js'
    ];

    public $jsOptions = [
        'type'=>'module',
        'charset'=>"utf-8"
    ];

    public $depends = [
        'common\widgets\firevue\VueJsAsset'
    ];


    public static $location = 'main-base';

   
    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile)
    {
        $basePath = \Yii::$app->assetManager->getPublishedUrl('@vue/public/utli');
        $view->registerJsFile($basePath.'/'.$jsfile, [ThemeAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }

    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile)
    {
        $basePath = \Yii::$app->assetManager->getPublishedUrl('@vue/public/utli');

        $view->registerCssFile($basePath.'/'.$cssfile, [ThemeAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
