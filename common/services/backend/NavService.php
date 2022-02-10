<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 14:28:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-17 18:19:36
 */

namespace common\services\backend;

use Yii;
use common\services\BaseService;
use common\helpers\ArrayHelper;
use common\helpers\CacheHelper;
use common\helpers\FileHelper;
use diandi\addons\models\AddonsUser;
use diandi\admin\components\MenuHelper;
use diandi\admin\models\Menu;
use diandi\admin\models\MenuTop;

/**
 * Class SmsService.
 *
 * @author chunchun <2192138785@qq.com>
 */
class NavService extends BaseService
{
    public  static $module_names;

    public function getMenuTop($types)
    {
        global $_GPC;
        $keys = 'menu_top_' . Yii::$app->user->id;
        $list = Yii::$app->cache->get($keys);
        if ($list) {
            return $list;
        } else {
            $list = MenuTop::find()->where(['mark' => $types])->orderBy('sort')->asArray()->all();
            $cacheClass = new CacheHelper();
            $cacheClass->set($keys, $list);

            return $list;
        }

        return [];
    }


    public function getLeftMenuTop()
    {
        global $_GPC;


        // $lists[] = 'system'; 

        $lists = array_merge([
            0 => [
                'title' => '系统',
                'identifie' => 'system'
            ]
        ], self::$module_names);

        foreach ($lists as $key => &$value) {
            $value['name'] = $value['title'];
            $value['mark'] = $value['identifie'];
            $value['icon'] = '';
            $value['targetType'] = 'top-nav';
            $value['url'] = "system/welcome/{$value['mark']}";
        }

        return $lists;
    }

    public function getMenu($location = '', $is_addons = false)
    {
        global $_GPC;
        $Website   = Yii::$app->settings->getAllBySection('Website');

        // menu_type 顶级分类0 左侧分类1
        if ($Website['menu_type'] == 1 && empty($_GPC['addons'])) {

            $allMenu = $this->allLeftMenu($is_addons);
            $menucate = $this->getLeftMenuTop();
        } else {
            $allMenu = $this->allMenu($is_addons);
            $types = array_column($allMenu, 'type', 'type');
            $menucate = $this->getMenuTop($types);
        }

        foreach ($menucate as $key => &$value) {
            $value['text'] = $value['name'];
            $value['icon'] = $value['icon'];
            $value['targetType'] = 'top-nav';
            $value['url'] = "system/welcome/{$value['mark']}";
        }
        if (!$is_addons) {
            $menus = [
                'top' => $menucate,
                'left' => $allMenu,
            ];
        } else {
            $menus = $this->ModuleMenu($allMenu);
        }
        if (in_array($location, ['top', 'left'])) {
            return json_encode($menus[$location], JSON_UNESCAPED_UNICODE);
        } else {
            return $menus;
        }
    }

    public function allMenu($is_addons)
    {
        $module_name = Yii::$app->params['addons'] ? Yii::$app->params['addons'] : 'system';
        $key = 'backend_' . Yii::$app->user->id . '_' . $module_name . 'initmenu_' . $is_addons;


        $initmenu = Yii::$app->cache->get($key);
        if ($initmenu) {
            return $initmenu;
        } else {
            $callback = function ($menu) use ($module_name) {
                $data = json_decode($menu['data'], true);
                $items = $menu['children'];
                $type = Yii::$app->params['plugins'];

                if ($menu['type'] == 'plugins') {
                    $parent_id = intval($menu['parent']);
                    $parent = $parent_id > 0 ? $parent_id : $menu['id'];

                    $menu_type = $menu['type'] . $parent;
                    // $module_name = $menu['module_name'];
                    // $addonsdefault = "/{$module_name}/default/index";
                } else {
                    $menu_type = $menu['type'];
                }

                $return = [
                    'id' => $menu['id'],
                    'text' => $menu['name'],
                    'order' => $menu['order'] ? $menu['order'] : 0,
                    'icon' => $menu['icon'],
                    'type' => $menu_type,
                    'targetType' => 'iframe-tab',
                    'url' => $menu['route'],
                ];

                //处理我们的配置
                if ($data) {
                    isset($data['visible']) && $return['visible'] = $data['visible']; //visible
                    isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon']; //icon
                    //other attribute e.g. class...
                    $return['options'] = $data;
                }

                //没配置图标的显示默认图标
                (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-fw fa-cube';

                if (!empty($items)) {
                    $return['children'] = $items;
                } else {
                    $return['children'] = [];
                }

                if ($type == $return['type']) {
                    $return['is_show'] = 'show';
                } else {
                    $return['is_show'] = 'hide';
                }

                return  $return;
            };


            $where = [];

            if (!$is_addons) {
                $where = ['is_sys' => 'system'];
            } else {
                $where = ['is_sys' => 'addons', 'module_name' => $module_name];
            }

            $initmenus = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, $where);
            $initmenu = ArrayHelper::arraySort($initmenus, 'order');

            $cacheClass = new CacheHelper();
            $cacheClass->set('backend_' . $module_name . 'initmenu_' . $is_addons, $initmenu);
            return $initmenu;
        }
    }



    public function allLeftMenu($is_addons)
    {
        $Website   = Yii::$app->settings->getAllBySection('Website');

        $module_names = AddonsUser::find()->where([
            'user_id' => Yii::$app->user->id
        ])->andWhere(['!=', 'd.identifie', ''])->alias('a')->joinWith(['addons as d'])->select(['identifie', 'title'])->asArray()->all();

        self::$module_names = $module_names;

        $key = 'backend_' . Yii::$app->user->id . '_' . 'initmenu_' . $is_addons;

        $module_name = array_column($module_names, 'identifie');
        $initmenu = Yii::$app->cache->get($key);
        if ($initmenu) {
            return $initmenu;
        } else {
            $callback = function ($menu) use ($module_name) {
                $data = json_decode($menu['data'], true);
                $items = $menu['children'];
                $type = Yii::$app->params['plugins'];

                if ($menu['is_sys'] == 'system') {
                    $parent_id = intval($menu['parent']);
                    $parent = $parent_id > 0 ? $parent_id : $menu['id'];

                    $menu_type = 'system';
                    // $module_name = $menu['module_name'];
                    // $addonsdefault = "/{$module_name}/default/index";
                } else {
                    $menu_type = $menu['module_name'];
                }

                $return = [
                    'id' => $menu['id'],
                    'text' => $menu['name'],
                    'order' => $menu['order'] ? $menu['order'] : 0,
                    'icon' => $menu['icon'],
                    'type' => $menu_type,
                    'targetType' => 'iframe-tab',
                    'url' => $menu['route'],
                ];

                //处理我们的配置
                if ($data) {
                    isset($data['visible']) && $return['visible'] = $data['visible']; //visible
                    isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon']; //icon
                    //other attribute e.g. class...
                    $return['options'] = $data;
                }

                //没配置图标的显示默认图标
                (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-fw fa-cube';

                if (!empty($items)) {
                    $return['children'] = $items;
                } else {
                    $return['children'] = [];
                }

                if ($type == $return['type']) {
                    $return['is_show'] = 'show';
                } else {
                    $return['is_show'] = 'hide';
                }

                return  $return;
            };


            $where = [];


            $where = ['or', ['is_sys' => 'system'], ['module_name' => $module_name]];



            $initmenus = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, $where);
            $initmenu = ArrayHelper::arraySort($initmenus, 'order');

            $cacheClass = new CacheHelper();
            $cacheClass->set('backend_' . $module_name . 'initmenu_' . $is_addons, $initmenu);
            return $initmenu;
        }
    }

    // 处理模块菜单

    public function ModuleMenu($allMenu = [])
    {
        $top = [];
        $allMenus = [];
        $leftMenu = [];
        $allMenus = ArrayHelper::removeByValue($allMenu, '', 'id');
        $num = 0;
        foreach (array_values($allMenus) as $key => $value) {
            $value['mark'] = $value['type'];
            $value['targetType'] = 'top-nav';
            if (isset($value['children'])) {
                foreach ($value['children'] as $k => $child) {
                    if ($num  == 0) {
                        $child['is_show'] = 'show';
                    }
                    if (!empty($child['children'])) {
                        foreach ($child['children'] as $key => &$val) {
                            if ($num  == 0) {
                                $val['is_show'] = 'show';
                            }
                            $val['type']  = $child['type'];
                        }
                    }

                    $leftMenu[] = $child;
                }
                unset($value['children'], $value['is_show'], $value['type']);
                $top[] = $value;
                $num++;
            } else {
                unset($allMenus[$key]);
            }
        }
        $menus = [
            'top' => $top,
            'left' => $leftMenu,
        ];

        return $menus;
    }


    public static function addonsMens($addons)
    {
        $list =  Menu::find()->where(['module_name' => $addons])->asArray()->all();
        $lists = ArrayHelper::itemsMerge($list, 0, 'id', 'parent', 'child', 3);
        //    去除id
        $menu = ArrayHelper::removeByKey($lists);
        $menus = ArrayHelper::removeByKey($menu, 'parent');
        $text = '<?php return ' . var_export($menus, true) . ';';
        $configFile =  Yii::getAlias('@addons/' . $addons . '/config');
        if (!is_dir($configFile)) {
            FileHelper::mkdirs($configFile);
            @chmod($configFile, 0777);
        }
        $file = Yii::getAlias('@addons/' . $addons . '/config/menu.php');

        if (false !== fopen($file, 'w+')) {
            file_put_contents($file, $text);
        } else {
            echo '创建失败';
        }

        return   $menus;
    }
}
