<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-17 09:25:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-16 18:45:29
 */

namespace ddswoole\components\mqtt;

use ddswoole\servers\BaseServer;
use ddswoole\traits\InteractsWithSwooleTable;
use diandi\swoole\web\Application;
use diandi\swoole\websocket\Context;
use Simps\MQTT\Protocol\Types;
use Simps\MQTT\Protocol\V5;
use Simps\MQTT\Tools\Common;

class MqttServer extends BaseServer
{
    use InteractsWithSwooleTable;

    public $onWorkStartCallable;

    private $application;

    private $config;

    public $channelNum = 20;

    public $port = 1883;

    /**
     * 上下文.
     *
     * @var [type]
     * @date 2022-09-15
     *
     * @example
     *
     * @author wang chunSheng
     *
     * @since
     */
    public $context;

    public $pool;

    public $workerId;

    public $app;

    public $type;

    public $tables;

    /**
     * @var array 服务器选项
     */
    public $options = [
        'open_mqtt_protocol' => true,
        'worker_num' => 2,
        'package_max_length' => 2 * 1024 * 1024,
    ];

    /**
     * 重新实例化application.完成各种类的注入.
     *
     * @param [type] $config
     * @param [type] $callable
     * @date 2022-09-02
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function __construct($config, $callable, Context $context)
    {
        $this->onWorkStartCallable = $callable;
        $this->config = $config['app'];
        $this->context = $context;
        parent::__construct($config);
    }

    public function init()
    {
        $this->application = new Application($this->config);
        if (!empty($this->tables) && is_array($this->tables)) {
            $this->prepareTables($this->tables);
        }
    }

    /**
     * 运行入口.
     *
     * @return void
     * @date 2022-09-21
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function run()
    {
        parent::run();
    }

    // public function events()
    // {
    //     $events = [
    //         'start' => [$this, 'onStart'],
    //         'workerStart' => [$this, 'onWorkerStart'],
    //         'WorkerStop' => [$this, 'onWorkerStop'],
    //         'workerError' => [$this, 'onWorkerError'],
    //         'receive' => [$this, 'onReceive'],
    //         'connect' => [$this, 'onConnect'],
    //         'task' => [$this, 'onTask'],
    //     ];

    //     return $events;
    // }

    /**
     * 上下文初始化.
     *
     * @return void
     * @date 2022-09-05
     *
     * @example
     *
     * @author Li Jinfang
     *
     * @since
     */
    public function ContextInit()
    {
        // code...
    }

    /**
     * 工作进程启动时实例化框架.
     *
     * @param \Swoole\Http\Server $server
     * @param int                 $workerId
     *
     * @throws InvalidConfigException
     */
    public function onWorkerStart(\Swoole\Server $server, $workerId)
    {
        if ($this->onWorkStartCallable) {
            call_user_func_array([$this->onWorkStartCallable, 'bootstrap'], [$this->application]);
            // $this->onWorkStartCallable = null;
        }
        $this->context->setContextDataByKey(Context::COROUTINE_APP, $this->application);
    }

    public function onReceive(\Swoole\Server $server, int $fd, int $reactorId, string $data)
    {
        try {
            // debug
            //        Common::printf($data);
            $data = V5::unpack($data);
            if (is_array($data) && isset($data['type'])) {
                switch ($data['type']) {
                    case Types::CONNECT:
                        // Check protocol_name
                        if ($data['protocol_name'] != 'MQTT') {
                            $server->close($fd);

                            return false;
                        }

                        // Check connection information, etc.

                        $server->send(
                            $fd,
                            V5::pack(
                                [
                                    'type' => Types::CONNACK,
                                    'code' => 0,
                                    'session_present' => 0,
                                    'properties' => [
                                        'maximum_packet_size' => 1048576,
                                        'retain_available' => true,
                                        'shared_subscription_available' => true,
                                        'subscription_identifier_available' => true,
                                        'topic_alias_maximum' => 65535, //0
                                        'wildcard_subscription_available' => true,
                                    ],
                                ]
                            )
                        );
                        break;
                    case Types::PINGREQ:
                        $server->send($fd, V5::pack(['type' => Types::PINGRESP]));
                        break;
                    case Types::DISCONNECT:
                        if ($server->exist($fd)) {
                            $server->close($fd);
                        }
                        break;
                    case Types::PUBLISH:
                        // Send to subscribers
                        var_dump($server->connections);
                        foreach ($server->connections as $sub_fd) {
                            if ($sub_fd != $fd) {
                                $server->send(
                                    $sub_fd,
                                    V5::pack(
                                        [
                                            'type' => $data['type'],
                                            'topic' => $data['topic'],
                                            'message' => $data['message'],
                                            'dup' => $data['dup'],
                                            'qos' => $data['qos'],
                                            'retain' => $data['retain'],
                                            'message_id' => $data['message_id'] ?? 0,
                                        ]
                                    )
                                );
                            }
                        }

                        if ($data['qos'] === 1) {
                            $server->send(
                                $fd,
                                V5::pack(
                                    [
                                        'type' => Types::PUBACK,
                                        'message_id' => $data['message_id'] ?? 0,
                                    ]
                                )
                            );
                        }

                        break;
                    case Types::SUBSCRIBE:
                        $payload = [];
                        foreach ($data['topics'] as $k => $option) {
                            $qos = $option['qos'];
                            if (is_numeric($qos) && $qos < 3) {
                                $payload[] = $qos;
                            } else {
                                $payload[] = \Simps\MQTT\Hex\ReasonCode::QOS_NOT_SUPPORTED;
                            }
                        }
                        $server->send(
                            $fd,
                            V5::pack(
                                [
                                    'type' => Types::SUBACK,
                                    'message_id' => $data['message_id'] ?? 0,
                                    'codes' => $payload,
                                ]
                            )
                        );
                        break;
                    case Types::UNSUBSCRIBE:
                        $payload = [];
                        foreach ($data['topics'] as $k => $qos) {
                            if (is_numeric($qos) && $qos < 3) {
                                $payload[] = $qos;
                            } else {
                                $payload[] = 0x80;
                            }
                        }
                        $server->send(
                            $fd,
                            V5::pack(
                                [
                                    'type' => Types::UNSUBACK,
                                    'message_id' => $data['message_id'] ?? 0,
                                    'codes' => $payload,
                                ]
                            )
                        );
                        break;
                }
            } else {
                $server->close($fd);
            }
        } catch (\Throwable $e) {
            echo "\033[0;31mError: {$e->getMessage()}\033[0m\r\n";
            $server->close($fd);
        }
    }
}
