<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:00:57
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-19 14:54:31
 */


namespace app\modules\diandi_integral;

use common\helpers\ArrayHelper;
use diandi\addons\models\searchs\DdAddons;
use diandi\admin\components\MenuHelper;
use Yii;

class module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'App\modules\diandi_integral\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        /* 加载语言包 */
        if (!isset(Yii::$app->i18n->translations['diandi_integral'])) {
            Yii::$app->i18n->translations['diandi_integral'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@backend/modules/diandi_integral/messages',
            ];
        }
        $config = require(__DIR__ . '/config.php');

        Yii::$app->params['menu'] = $this->getMenus();
        // 获取应用程序的组件
        $components = \Yii::$app->getComponents();

        // 遍历子模块独立配置的组件部分，并继承应用程序的组件配置
        foreach ($config['components'] as $k => $component) {
            if (isset($component['class']) && !isset($components[$k])) {
                continue;
            }
            $config['components'][$k] = array_merge($components[$k], $component);
        }
        // 将新的配置设置到应用程序
        // 很多都是写 Yii::configure($this, $config)，但是并不适用子模块，必须写 Yii::$App
        \Yii::configure(\Yii::$app, $config);
    }

    public function getMenus(): array
    {
        $modules = DdAddons::findOne(['identifie' => $this->id]);
        $callback = function ($menu) {
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'id' => $menu['id'],
                'text' => $menu['name'],
                'icon' => $menu['icon'],
                'order' => $menu['order'],
                'type' => $menu['type'],
                'targetType' => "iframe-tab",
                'url' => $menu['route'],
            ];
            //处理我们的配置
            if ($data) {
                isset($data['visible']) && $return['visible'] = $data['visible']; //visible
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon']; //icon
                $return['options'] = $data;
            }

            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
            $items && $return['children'] = $items;
            return  $return;
        };

        $is_addons = true;
        $where = ['is_sys' => 'addons', 'module_name' => $this->id];
        $menus = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, $where);
        return ArrayHelper::arraySort($menus, 'order', 'asc');
    }
}
