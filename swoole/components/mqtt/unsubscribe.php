<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-16 12:41:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-16 13:12:06
 */

/**
 * This file is part of Simps.
 *
 * @see     https://github.com/simps/mqtt
 * @contact  Lu Fei <lufei@simps.io>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
include __DIR__.'/../bootstrap.php';

use Simps\MQTT\Client;
use Swoole\Coroutine;

Coroutine\run(function () {
    $client = new Client(SIMPS_MQTT_LOCAL_HOST, SIMPS_MQTT_PORT, getTestMQTT5ConnectConfig());
    $client->connect();
    $topics = ['simps-mqtt/user001/get'];
    $res = $client->unsubscribe($topics);
    var_dump($res);
});