<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-16 18:48:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-16 18:50:31
 */

namespace ddswoole\servers;

use common\services\BaseService;
use Simps\MQTT\Client;
use Simps\MQTT\Config\ClientConfig;

class ConfigServer extends BaseService
{
    public static function getTestConnectConfig($mqttConf)
    {
        $config = new ClientConfig();

        return $config->setUserName('chunchun')
        ->setPassword('chunchun')
        ->setClientId(Client::genClientID())
        ->setKeepAlive(10)
        ->setDelay(3000) // 3s
        ->setMaxAttempts(5)
        ->setSwooleConfig($mqttConf);
    }

    public static function getTestMQTT5ConnectConfig($mqttConf)
    {
        $config = new ClientConfig();

        return $config->setUserName('chunchun')
        ->setPassword('chunchun')
        ->setClientId(Client::genClientID())
        ->setKeepAlive(10)
        ->setDelay(3000) // 3s
        ->setMaxAttempts(5)
        ->setProperties([
            'session_expiry_interval' => 60,
            'receive_maximum' => 65535,
            'topic_alias_maximum' => 65535,
        ])
        ->setProtocolLevel(5)
        ->setSwooleConfig($mqttConf);
    }
}
