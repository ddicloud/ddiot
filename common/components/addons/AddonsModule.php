<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 09:30:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-19 09:09:00
 */

namespace common\components\addons;

use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\StringHelper;
use diandi\addons\models\searchs\DdAddons;
use diandi\admin\components\MenuHelper;
use Yii;
use yii\base\Module;
use yii\web\HttpException;

/**
 *
 * @property-read array $menus
 */
class AddonsModule extends Module
{
    /**
     * @throws HttpException
     */
    public function init(): void
    {
        global $_GPC;

        $logPath = Yii::getAlias('@runtime/base/addons/' . date('ymd') . '.log');

        $module = $this->id;

        $config = [];
        Yii::$app->params['bloc_id'] = Yii::$app->service->commonGlobalsService->getBloc_id();
        Yii::$app->params['store_id'] = Yii::$app->service->commonGlobalsService->getStore_id();
        FileHelper::writeLog($logPath, '模块api父类', [Yii::$app->params['bloc_id'], Yii::$app->params['store_id']]);

        $store_id = Yii::$app->params['store_id'];

        $requestedRoute = $this->module->requestedRoute??'';
        FileHelper::writeLog($logPath, '请求地址', [$requestedRoute, $this->module]);

        if (empty($store_id) && Yii::$app->id == 'app-api' && !StringHelper::strExists($requestedRoute, 'notify') && !StringHelper::strExists($requestedRoute, 'admin/auth')) {
            throw new HttpException(400, '请选择商户后操作');
        }

        /* 加载语言包 */
        if (!isset(Yii::$app->i18n->translations[$module])) {
            Yii::$app->i18n->translations[$module] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@addons/' . $module . '/messagess',
            ];
        }

        $appId = Yii::$app->id;
        $configPath = '';
        switch ($appId) {
            case 'app-admin':
                $configPath = Yii::getAlias('@addons/' . $module . '/config/amdin.php');
                Yii::$app->params['menu'] = $this->getMenus();
                $cookies = Yii::$app->response->cookies;
                // 添加一个cookie
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'language',
                    'value' => 'zh-CN',
                ]));
                break;
            case 'app-frontend':
                $configPath = Yii::getAlias('@addons/' . $module . '/config/frontend.php');
                break;
            case 'app-console':
                $runtimePath = Yii::getAlias('@App/runtime/' . $module . '/swoole');
                // define('SWOOLE_RUNTIME', $runtimePath);
                FileHelper::mkdirs($runtimePath);
                if (is_dir($runtimePath)) {
                    @chmod($runtimePath, 0777);
                }
                $files = ['baseserver.log', 'baseserver.pid', 'swoole.log', 'swoole.log'];
                foreach ($files as $key => $value) {
                    if (!file_exists($runtimePath . '/' . $value)) {
                        file_put_contents($runtimePath . '/' . $value, '');
                        @chmod($runtimePath . '/' . $value, 0777);
                    }
                }
                break;
            case 'app-api':
            case 'app-swoole':
            default:
                $configPath = Yii::getAlias('@addons/' . $module . '/config/api.php');
                $cookies = Yii::$app->response->cookies;
                // 添加一个cookie
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'language',
                    'value' => 'zh-CN',
                ]));
                break;
        }

        if (file_exists($configPath)) {
            $config = require $configPath;
        }

        // 获取应用程序的组件
        $components = \Yii::$app->getComponents();

        if (!empty($config['components'])) {
            // 遍历子模块独立配置的组件部分，并继承应用程序的组件配置
            foreach ($config['components'] as $k => $component) {
                if (isset($component['class']) && !isset($components[$k])) {
                    continue;
                }
                $config['components'][$k] = array_merge($components[$k], $component);
            }

            Yii::$app->setComponents($config['components']);
        }

        if (in_array($appId, ['app-swoole', 'app-api', 'app-frontend'])) {
            // 初始化公众号配置信息
            $this->initWechat();
        }
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
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
            $items && $return['children'] = $items;

            return $return;
        };
        $where = ['is_sys' => 'addons', 'module_name' => $this->id];
        $menus = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, $where);

        return ArrayHelper::arraySort($menus, 'order', 'asc');
    }

    public function initWechat(): void
    {
        global $_GPC;
        $store_id = $_GPC['store_id'];
        $config = require Yii::getAlias('@api/modules/officialaccount/config.php');

        $params = Yii::$app->params;
        $conf = $params['conf'];

        $Wechatpay = $conf['wechatpay'];
        $wechat = $conf['wechat'];

        $pemPath = Yii::getAlias('@api/web/store/' . $store_id . '/officialaccount/cert');

        if (!is_dir($pemPath)) {
            FileHelper::mkdirs($pemPath);
        }

        $apiclient_cert = !empty($Wechatpay['apiclient_cert'])  ?? Yii::getAlias('@attachment/' . $Wechatpay['apiclient_cert']['url']);
        $apiclient_key = !empty($Wechatpay['apiclient_key'])  ?? Yii::getAlias('@attachment/' . $Wechatpay['apiclient_key']['url']);

        // 支付参数设置
        $config['params']['wechatPaymentConfig'] = [
            'app_id' => $Wechatpay ? $Wechatpay['app_id'] : '',
            'mch_id' => $Wechatpay ? $Wechatpay['mch_id'] : '',
            'key' => $Wechatpay ? $Wechatpay['key'] : '', // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path' => $apiclient_cert, // XXX: 绝对路径！！！！
            'key_path' => $apiclient_key, // XXX: 绝对路径！！！！
            'notify_url' => Yii::$app->request->hostInfo . '/api/wechat/basics/notify',
        ];

        $redirect_uri = !empty($_GPC['redirect_uri']) ? $_GPC['redirect_uri'] : '';

        // 公众号设置
        $wechatConfig = [
            /*
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id' => $wechat ? $wechat['app_id'] : '',
            'secret' => $wechat ? $wechat['secret'] : '',
            'token' => $wechat ? $wechat['token'] : '', // Token
            'aes_key' => $wechat ? $wechat['aes_key'] : '',
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => $redirect_uri,
            ],
            // 日志配置
            'log' => [
                'default' => 'dev', // 默认使用的 channel，生产环境可以改为下面的 prod
                'channels' => [
                    // 测试环境
                    'dev' => [
                        'driver' => 'single',
                        'path' => Yii::getAlias('@api/runtime/officialaccount/' . date('Ym/d') . '.log'),
                        'level' => 'debug',
                    ],
                    // 生产环境
                    'prod' => [
                        'driver' => 'daily',
                        'path' => Yii::getAlias('@api/runtime/officialaccount/' . date('Ym/d') . '.log'),
                        'level' => 'info',
                    ],
                ],
            ],
        ];

        $config['params']['wechatConfig'] = array_merge($config['params']['wechatConfig'], $wechatConfig);
        $Wxapp = $conf['wxapp'];

        // 小程序初始化
        // 小程序参数设置
        $config['params']['wechatMiniProgramConfig'] = [
            'app_id' => $Wxapp ? $Wxapp['AppId'] : '',
            'secret' => $Wxapp ? $Wxapp['AppSecret'] : '',
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'file' => Yii::getAlias('@runtime/miniprogram'),
            ],
            //必须添加部分
            'guzzle' => [ // 配置
                'verify' => false,
                'timeout' => 4.0,
            ],
        ];

        $params = Yii::$app->params;

        foreach ($params as $key => $value) {
            if (!isset($config['params'][$key])) {
                $config['params'][$key] = $value;
            }
        }
        // 将新的配置设置到应用程序
        // 很多都是写 Yii::configure($this, $config)，但是并不适用子模块，必须写 Yii::$App
        \Yii::configure(\Yii::$app, $config);
    }
}
