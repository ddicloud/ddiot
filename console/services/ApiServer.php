<?php

namespace console\services;


use common\helpers\FileHelper;
use Yii;

class ApiServer
{
    public static function createApiJs($addons)
    {
        $apiPath = Yii::getAlias('@addons/' . $addons . '/config/api.php');
        $apiArr = require_once($apiPath);

        $apiBase = <<<EOF
import sendHttp from "@/uni_modules/ddiot-ui/js_sdk/http/index.js"
EOF;
        $apiBase .= PHP_EOL;
        foreach ($apiArr as $item) {
            $path = '/' . str_replace("\\", "/", $item['controller'][0]);
            foreach ($item['extraPatterns'] as $key => $extraPattern) {
                [$method, $api] = explode(' ', $key);
                $apiBasePath = $path .'/'. $api;
                $apiName = self::createApiName($apiBasePath);
                $apiBase .= <<<EOF
export function $apiName() {
	return sendHttp('$apiBasePath', "$method", {}, true)
}
EOF;
                $apiBase .= PHP_EOL;
            }
        }
        $vueApi = Yii::getAlias('@addons/' . $addons . '/config/api.js');
        $configFile = Yii::getAlias('@addons/' . $addons . '/config');
        if (!is_dir($configFile)) {
            FileHelper::mkdirs($configFile);
            @chmod($configFile, 0777);
        }

        if (false !== fopen($vueApi, 'w+')) {
            file_put_contents($vueApi, $apiBase);
            echo '接口文件创建成功' . PHP_EOL;
        }

    }

    public static function createApiName($apiBasePath): string
    {

        $apiFunc = explode('/', $apiBasePath);
        $ApiName = '';
        // 遍历数组中的每个元素
        foreach ($apiFunc as $word) {
            // 将每个元素的首字母转换为大写，并将其添加到新的字符串中
            $word = str_replace('-','',$word);
            $word = str_replace('_','',$word);
            $new_word = ucwords($word);
            $ApiName .= $new_word;
        }

        return $ApiName;
    }
}