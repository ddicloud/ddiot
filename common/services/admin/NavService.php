<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:18:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-18 17:08:30
 */

namespace common\services\admin;

use admin\models\auth\AuthRoute;
use common\helpers\ArrayHelper;
use common\helpers\CacheHelper;
use common\helpers\FileHelper;
use common\services\BaseService;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\DdAddons;
use diandi\admin\components\MenuHelper;
use diandi\admin\models\Menu;
use Yii;

/**
 * Class SmsService.
 *
 * @author chunchun <2192138785@qq.com>
 */
class NavService extends BaseService
{
    public static array $module_names;

    public function getMenuTop($types): array|string
   {
        // $lists[] = 'system';

        $lists = array_merge([
            0 => [
                'title' => '系统',
                'identifie' => 'system',
            ],
        ], self::$module_names);

        foreach ($lists as $key => &$value) {
            $value['name'] = $value['title'];
            $value['mark'] = $value['identifie'];
            $value['icon'] = '';
            $value['targetType'] = 'top-nav';

            $value['url'] = !empty($value['mark']) ? "system/welcome/{$value['mark']}" : '';
        }

        return $lists;
    }

    public function getMenu($location = '', $is_addons = false): array|bool|string
    {
        $allMenu = $this->allMenu();

        $types = array_column($allMenu, 'type', 'type');

        $menucate = $this->getMenuTop($types);

        foreach ($menucate as $key => &$value) {
            $value['text'] = $value['title'];
            $value['targetType'] = 'top-nav';
            $mark = !empty($value['mark'])  ? $value['mark'] : '';
            $value['url'] = "system/welcome/{$mark}";
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

    public function allMenu()
    {
        $module_names = AddonsUser::find()->where([
            'user_id' => Yii::$app->user->id,
        ])->andWhere(['!=', 'd.identifie', ''])->alias('a')->joinWith(['addons as d'])->select(['identifie', 'title'])->asArray()->all();

        self::$module_names = $module_names;

        $module_name = array_column($module_names, 'identifie');
        $key = 'auth_' . Yii::$app->user->id . '_' . 'initmenu';

        $initmenu = Yii::$app->cache->get($key);

        // $pluginsMenus = self::getPluginsMenuId();

        if ($initmenu) {
            return $initmenu;
        } else {
            // 获取所有的路由
            $routeList = AuthRoute::find()->indexBy('id')->select(['id', 'route_name'])->asArray()->all();
            $callback = function ($menu) use ($module_name, $routeList) {
                $route_name = !empty($routeList[$menu['route_id']]) ? $routeList[$menu['route_id']]['route_name'] : '';
                // 解析地址路由参数
                $data = $menu['data'] ? json_decode($menu['data'], true) : [];

                $parent_id = intval($menu['parent']);

                //区分系统菜单和扩展模块菜单

                if ($menu['is_sys'] === 1) {
                    $parent_id = intval($menu['parent']);
//                    $parent = $parent_id > 0 ? $parent_id : $menu['id'];
                    $menu_type = 'system';
                    // $module_name = $menu['module_name'];
                    // $addonsdefault = "/{$module_name}/default/index";
                } else {
                    $menu_type = $menu['module_name'];
                }

                $route = $menu['route'];

                // 校验是否存在子模块
                // $parent_menu_id = 0;
                // if (!empty($pluginsMenus[$menu_type])) {
                //     $parent_menu_id = $pluginsMenus[$menu_type];
                // }

                $return = [
                    'id' => $menu['id'],
                    'hidden' => !($menu['is_show'] == 0),
                    'parent' => $parent_id,
                    'order' => (int) $menu['order'],
                    'name' => $route_name,
                    'level_type' => $menu['level_type'],
                    'type' => $menu_type,
                    'meta' => [
                        'parent_menu_id' => 0,
                        'title' => $menu['name'],
                        'icon' => $menu['icon'],
                        'affix' => $menu['name'] === '工作台' && !empty($parent_id),
                        'parent' => $parent_id,
                    ],
                    'path' => $route ?? '/' . $menu['id'],
                    'children' => $menu['children'],
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

                return  $return;
            };
            $where = ['or', ['is_sys' => 1], ['module_name' => $module_name]];
            $user_id = Yii::$app->user->id;
            $initmenus = MenuHelper::getAssignedMenu($user_id, null, $callback, $where, 1);
            $initmenu = ArrayHelper::arraySort($initmenus, 'order');
            $initmenuList = $this->menuChildRoute($initmenu);
            $cacheClass = new CacheHelper();
            $cacheClass->set($key, $initmenuList);

            return $initmenuList;
        }
    }

    // 处理模块菜单

    public function ModuleMenu($allMenu = []): array
    {
        $top = [];
        $leftMenu = [];
        $allMenus = ArrayHelper::removeByValue($allMenu, '');
        $num = 0;
        foreach (array_values($allMenus) as $key => $value) {
            $value['mark'] = $value['type'];
            $value['targetType'] = 'top-nav';
            if (isset($value['children'])) {
                foreach ($value['children'] as $k => $child) {
                    if ($num == 0) {
                        $child['is_show'] = 'show';
                    }
                    if (!empty($child['children'])) {
                        foreach ($child['children'] as $key => &$val) {
                            if ($num == 0) {
                                $val['is_show'] = 'show';
                            }
                            $val['type'] = $child['type'];
                        }
                    }

                    $leftMenu[] = $child;
                }
                unset($value['children'], $value['is_show'], $value['type']);
                $top[] = $value;
                ++$num;
            } else {
                unset($allMenus[$key]);
            }
        }
        return [
            'top' => $top,
            'left' => $leftMenu,
        ];
    }

    public static function addonsMens($addons): array
    {
        $list = Menu::find()->where(['module_name' => $addons])->with(['router' => function ($query) {
            return  $query->with(['item']);
        }])->asArray()->all();

        foreach ($list as &$value) {
            if (!empty($value['router']) && is_array($value['router'])) {
                unset($value['router']['id'], $value['router']['created_at'], $value['router']['updated_at']);
                if (!empty($value['router']['item']) && is_array($value['router']['item'])) {
                    unset($value['router']['item']['id'], $value['router']['item']['created_at'], $value['router']['item']['updated_at']);
                }
            }
        }
        unset($value);
        $lists = ArrayHelper::itemsMerge($list, 0, 'id', 'parent', 'child', 3);
        //    去除id
        $menu = ArrayHelper::removeByKey($lists);
        $menus = ArrayHelper::removeByKey($menu, 'parent');
        $menus = ArrayHelper::removeByKey($menus, 'route_id');
        $text = '<?php return ' . var_export($menus, true) . ';';

        $configFile = Yii::getAlias('@addons/' . $addons . '/config');
        if (!is_dir($configFile)) {
            FileHelper::mkdirs($configFile);
            @chmod($configFile, 0777);
        }
        $file = Yii::getAlias('@addons/' . $addons . '/config/menu.php');

        if (false !== fopen($file, 'w+')) {
            file_put_contents($file, $text);
            echo '菜单创建成功' . PHP_EOL;
        } else {
            echo '菜单创建失败' . PHP_EOL;
        }

        return   $menus;
    }

    // 处理非页面菜单
    public static function menuChildRoute(&$menus = [])
    {
        foreach ($menus as $key => &$value) {
            if (!empty($value['children'])) {
                foreach ($value['children'] as $k => $val) {
                    if ($val['level_type'] == 6) {
                        array_unshift($value, $val);
                        unset($menus[$key]);
                    }

                    if ($val['children']) {
                        static::menuChildRoute($val['children']);
                    }
                }
            }
        }

        return array_values($menus);
    }

    // 获取父级模块应用菜单的ID
    public static function getPluginsMenuId()
    {
        $addon = DdAddons::find()->indexBy('mid')->asArray()->all();
        $addonsIdentifie = [];
        foreach ($addon as $key => $value) {
            if (!empty($value['parent_mids'])) {
                $parent_mids = explode(',', $value['parent_mids']);
                foreach ($parent_mids as $k => $val) {
                    $addon[$val]['child'][] = $value;
                    $addonOne = $addon[$val];
                    $addonsIdentifie[$addonOne['identifie']] = $addonOne;
                }
            }
        }

        // $addonsLevel = ArrayHelper::itemsMerge($addon, 0, 'mid', 'parent_mid', 'child');
        // $addonsIdentifie = ArrayHelper::arrayKey($addonsLevel, 'identifie');
        $pluginsMenus = Menu::find()->where(['name' => '应用', 'parent' => 0])->andWhere(['!=', 'module_name', 'sys'])->indexBy('module_name')->asArray()->all();
        // 以子模块为键值输出父级的菜单ID
        $lists = [];
        foreach ($pluginsMenus as $identifie => $value) {
            if (!empty($addonsIdentifie[$identifie])) {
                if (key_exists('child', $addonsIdentifie[$identifie]) && !empty($addonsIdentifie[$identifie]['child'])) {
                    foreach ($addonsIdentifie[$identifie]['child'] as $key => $val) {
                        $lists[$val['identifie']] = $value['id'];
                    }
                }
            }
        }

        return $lists;
    }
}
