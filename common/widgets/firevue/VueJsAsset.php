<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-03 12:29:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-12 23:32:55
 */

namespace common\widgets\firevue;

use common\widgets\adminlte\ThemeAsset;
use Exception;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class VueJsAsset.
 */
class VueJsAsset extends AssetBundle
{
    public $sourcePath = '@vue/';

    public $css = [
        'src/css/build.css',
        'src/css/require.css',
        // 'element-ui/lib/theme-chalk/index.css',
        // 'node_modules/element-ui/lib/theme-chalk/display.css'
        'style/default/index.css'
    ];

    public $js = [
        'src/js/manifest.js',
        // 'node_modules/vue/dist/vue.min.js',
        'src/js/lib/build.js',
        'src/js/lib/require.js',
        'public/utli/index.js',
    ];

    public $jsOptions = [
        'charset' => "utf-8",
        'position' => View::POS_HEAD
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];



    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     *
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = 'default';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('default' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }
            $this->css[] = sprintf('style/%s/index.css', trim($this->skin));
        }


        parent::init();
    }

    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile)
    {
        $basePath = \Yii::$app->assetManager->getPublishedUrl('@vue/');
        $view->registerJsFile($basePath . '/' . $jsfile, [ThemeAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }

    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile)
    {
        $basePath = \Yii::$app->assetManager->getPublishedUrl('@vue/');

        $view->registerCssFile($basePath . '/' . $cssfile, [ThemeAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
