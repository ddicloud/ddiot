<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-03 07:10:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-16 14:54:39
 */

namespace common\widgets\adminlte;

use Yii;
use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;

/**
 * AdminLte AssetBundle.
 *
 * @since 0.1
 */
class AdminLteAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@common/widgets/adminlte/asset/';
    public $css = [
        // 'node_modules/bootstrap/css/bootstrap.min.css',
        'dist/css/font-awesome.min.css',
        'dist/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/all-skins.min.css',
    ];
    public $js = [
        'dist/js/app.min.js',
        'dist/js/app_iframe.min.js',
    ];

    public $jsOptions = [
        // 'type'=>'module'
    ];

    public $depends = [
        'common\widgets\firevue\VuemainAsset',
        // 'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     *
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = 'all-skins';

    public $skins = [
        'skin-blue',
        'skin-black',
        'skin-purple',
        'skin-green',
        'skin-red',
        'skin-yellow',
        'skin-blue-light',
        'skin-black-light',
        'skin-purple-light',
        'skin-green-light',
        'skin-red-light',
        'skin-yellow-light'
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        global $_GPC;
     
        $this->skin = !empty(Yii::$app->cache->get('themcolor'))?Yii::$app->cache->get('themcolor'):Yii::$app->settings->get('Website', 'themcolor');
         // Append skin color file if specified
        if (in_array($this->skin,$this->skins)) {
            $this->css[] = sprintf('dist/css/skins/%s.min.css', trim($this->skin));
        }
        parent::init();
    }
}
