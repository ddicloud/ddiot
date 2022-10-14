<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 03:20:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-13 18:35:52
 */
namespace ddswoole\process;


use diandi\swoole\web\Application;
use Throwable;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\ErrorHandler;

/**
 * WorkServer.
 *
 * Class WebSocketServer
 */
class WorkServer extends Component
{
    /**
     * @var string 监听主机
     */
    public $host = '127.0.0.1';
    /**
     * @var int 监听端口
     */
    public $port = 9553;
    /**
     * @var int 进程模型
     */
    public $mode = SWOOLE_PROCESS;
    /**
     * @var int SOCKET类型
     */
    public $sockType = SWOOLE_SOCK_TCP;

    public $worker_id;

    public $process;

    
    public $connections;

    /**
     * @var array 服务器选项
     */
    public $options = [
        'worker_num' => 2,
        'daemonize' => 0,
        'task_worker_num' => 2,
        'daemonize' => false, // 守护进程执行
        'task_worker_num' => 4, //task进程的数量
        'ssl_cert_file' => '',
        'ssl_key_file' => '',
        'pid_file' => '',
        'log_file' => '',
        'log_level' => 0,
    ];
    

    /**
     * @var \Swoole\Server swoole server实例
     */
    public $server;

    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->server instanceof \Swoole\Server) {
            $this->server = new \Swoole\Server($this->host, $this->port, $this->mode, $this->sockType);

            // 您可以混合使用UDP/TCP，同时监听内网和外网端口，多端口监听参考 addlistener小节。
            // $this->server->addlistener("0.0.0.0", 9501, SWOOLE_SOCK_UDP); // 添加 TCP
            // 添加 Web Socket
            // $this->server->listen("0.0.0.0",$this->port,$this->sockType); // UDP
            // $this->server->addlistener("/var/run/myserv.sock", 0, SWOOLE_UNIX_STREAM); //UnixSocket Stream
            //  $this->server->addlistener("127.0.0.1", 9503, SWOOLE_SOCK_TCP | SWOOLE_SSL); //TCP + SSL

            $this->server->set($this->options);
        }

        foreach ($this->events() as $event => $callback) {
            if (method_exists($this, 'on'.$event)) {
                $this->server->on($event, $callback);
            }
        }
    }


    /**
     * 事件监听.
     *
     * @return array
     */
    public function events()
    {
        $events = [
            'start' => [$this, 'onStart'],
            'workerStart' => [$this, 'onWorkerStart'],
            'WorkerStop' => [$this, 'onWorkerStop'],
            'workerError' => [$this, 'onWorkerError'],
            'managerStart' => [$this, 'onManagerStart'],
            'managerStop' => [$this, 'onManagerStop'],
            'pipeMessage' => [$this, 'onPipeMessage'],
            'packet' => [$this, 'onPacket'],
            'receive' => [$this, 'onReceive'],
            'connect' => [$this, 'onConnect'],
            'close' => [$this, 'onClose'],
            'timer' => [$this, 'onTimer'],
            'shutdown' => [$this, 'onShutdown'],
        ];

        if (isset($this->options['task_worker_num'])) {
            $events['task'] = [$this, 'onTask'];
            $events['finish'] = [$this, 'onFinish'];
            if (isset($this->options['task_enable_coroutine']) && $this->options['task_enable_coroutine']) {
                $events['task'] = [$this, 'onCorTask'];
            }
        }

        return $events;
    }

    /**
     * 启动服务器.
     *
     * @return bool
     */
    public function start()
    {
        go(function()
        {
            return $this->server->start();
            
        });
    }

    /**
     * master启动.
     */
    public function onStart(\Swoole\Server $server)
    {
        printf("listen on %s:%d\n", $this->host, $this->port);
    }

    /**
     * 工作进程启动时实例化框架.
     *
     * @param int $workerId
     *
     * @throws InvalidConfigException
     */
    public function onWorkerStart(\Swoole\Server $server, $workerId)
    {
        global $argv;
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        try {
            Yii::$app->set('server', $server);
            if ($workerId >= $this->options['worker_num']) {
                @swoole_set_process_name("php {$argv[0]} task worker");
            } else {
                @swoole_set_process_name("php {$argv[0]} event worker");
            }
        } catch (\Exception $e) {
            print_r('start yii error:'.ErrorHandler::convertExceptionToString($e).PHP_EOL);
            // $this->server->shutdown();
        }
    }

    /**
     * 工作进程异常.
     *
     * @param $workerId
     * @param $workerPid
     * @param $exitCode
     * @param $signal
     */
    public function onWorkerError(\Swoole\Server $server, $workerId, $workerPid, $exitCode, $signal)
    {
        fprintf(STDERR, "worker error. id=%d pid=%d code=%d signal=%d\n", $workerId, $workerPid, $exitCode, $signal);
    }

    public function onShutdown(\Swoole\Server $server)
    {
    }

    public function onWorkerStop(\Swoole\Server $server, int $workerId)
    {
    }

    public function onWorkerExit(\Swoole\Server $server, int $workerId)
    {
    }

    public function onConnect(\Swoole\Server $server, int $fd, int $reactorId)
    {
        echo '链接成功';
    }

    public function onReceive(\Swoole\Server $server, int $fd, int $reactorId, string $data)
    {
        $socket = $this->process->exportSocket();
        $socket->send($data);
        // echo '[#'.$this->worker_id."]\tClient[$fd]: $data\n";
    }

    public function onPacket(\Swoole\Server $server, string $data, array $clientInfo)
    {
       
        echo "[#onPacket]\tClient[$clientInfo]: $data\n";
    }

    public function onPipeMessage(\Swoole\Server $server, int $src_worker_id, mixed $message)
    {
        echo '[#onPipeMessage]';
    }

    public function onManagerStart(\Swoole\Server $server)
    {
        echo '[#onManagerStart]';
    }

    public function onManagerStop(\Swoole\Server $server)
    {
        echo '[#onManagerStop]';
    }

    public function onBeforeReload(\Swoole\Server $server)
    {
        echo '[#onBeforeReload]';
    }

    public function onAfterReload(\Swoole\Server $server)
    {
        echo '[#onAfterReload]';
    }

    /**
     * 开启连接.
     *
     * @param $server
     * @param $frame
     */
    public function onOpen(\Swoole\Server $server, $frame)
    {
        echo "server: handshake success with fd{$frame->fd}\n";
        echo "server: {$frame->data}\n";

        // 验证token进行连接判断
    }

    /**
     * 关闭连接.
     *
     * @param $server
     * @param $fd
     */
    public function onClose(\Swoole\Server $server, $fd)
    {
        echo "client {$fd} closed".PHP_EOL;
    }

    
    public function addProcess($process)
    {
        $this->process = $process;
        $this->server->addProcess($process);
    } 

    /**
     * 处理异步任务
     *
     * @param $server
     * @param $task_id
     * @param $from_id
     * @param $data
     */
    public function onTask(\Swoole\Server $server, $task_id, $from_id, $data)
    {
        try {
            $handler = $data[0];
            $params = $data[1] ?? [];
            list($class, $action) = $handler;

            $obj = new $class();

            return call_user_func_array([$obj, $action], $params);
        } catch (Throwable $e) {
            Yii::$app->errorHandler->handleException($e);

            return 1;
        }
    }

    public function onCorTask(\Swoole\Server $server, \Swoole\Server\Task $task)
    {
    }

    public function getServer()
    {
        return $this->server;
    }

    /**
     * 处理异步任务的结果.
     *
     * @param $server
     * @param $task_id
     * @param $data
     */
    public function onFinish(\Swoole\Server $server, $task_id, $data)
    {
        echo "AsyncTask[$task_id] 完成: $data".PHP_EOL;
    }
}
