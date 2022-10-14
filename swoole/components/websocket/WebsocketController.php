<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-05 10:04:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-14 12:46:38
 */

namespace ddswoole\components\websocket;

use console\controllers\BaseController;
use ddswoole\bootstrap\Loader;
use ddswoole\interfaces\controllers\SwooleInterfaceController;
use ddswoole\process\Manager;
use ddswoole\process\WorkServer;
use diandi\swoole\websocket\Context;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;
use Swoole\Process\Pool;
use Yii;

/**
 * Undocumented class.
 *
 * @date 2022-06-05
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 * php ./yii diandi_watches/tcp/run --bloc_id=1 --store_id=1  建议使用
 * nohup php ./yii bracelet/run --bloc_id=1 --store_id=1 --addons=diandi_watches > /home/nohub/diandi_watches.log  2>&1 &
 * ps -ef|grep php|grep -v grep
 */
class WebsocketController extends BaseController implements SwooleInterfaceController
{
    public $server;

    public $addons;

    public $config;

    public function actions()
    {
        parent::actions();
        $confPath = Yii::getAlias('@addons/'.$this->addons.'/config/swoole_websocket.php');
        $CommonConfPath = Yii::getAlias('@common/config');
        if (file_exists($confPath)) {
            $config = require $confPath;
            $BaseConfig = yii\helpers\ArrayHelper::merge(
                [
                    'app' => [
                        'params' => yii\helpers\ArrayHelper::merge(
                            require($CommonConfPath.'/params.php'),
                            require($CommonConfPath.'/params-local.php'),
                        ),
                    ],
                ],
                require Yii::getAlias('@ddswoole/config/websocket.php'),
            );
            $this->config = yii\helpers\ArrayHelper::merge(
                $BaseConfig,
                $config
            );
        } else {
            throw new \Exception('配置文件不存在：'.$confPath);
        }
    }

    public function actionRun()
    {
        defined('COROUTINE_ENV') or define('COROUTINE_ENV', true);
        $serverName = $this->server;
        $listens[] = [
            'host' => '127.0.0.1',
            'port' => 9000,
        ];

        $pm = new Manager(SWOOLE_IPC_UNIXSOCK, $listens, 1);
        $pm->add(function (Pool $pool, int $workerId) use ($serverName) {
            //让每个OnWorkerStart回调都自动创建一个协程
            $Loader = new Loader();
            $context = new Context();
            $server = new $serverName($this->config, $Loader, $context, $pool, $workerId);

            return  $server->run();
        }, 'start', 1);

        $pm->add(function (Pool $pool, string $data) {
            echo 'we';
            var_dump($data);
        }, 'message');

        // $pm->add(function (Pool $pool, int $workerId) {
        //     $socket = new Coroutine\Socket(AF_INET, SOCK_STREAM, 0);
        //     $socket->bind('127.0.0.1', 9504);
        //     $socket->listen(128);
        //     while (true) {
        //         echo "Accept0: \n";
        //         print_r($socket);
        //         $client = $socket->accept();
        //         if ($client === false) {
        //             var_dump($socket->errCode);
        //         } else {
        //             echo "Accept1: \n";
        //             $client->send('11223344');
        //             print_r($client);
        //         }
        //     }
        // }, 'start', 1);

        $pm->add(function (Pool $pool, int $workerId) use ($serverName) {
            // $workServer = new WorkServer();
            $process = $pool->getProcess(0);
            // $workServer->addProcess($process);
            // return $workServer->start();
            $socket = $process->exportSocket();
            while (true) {
                echo '进程消息1：'.$socket->recv();
                $socket->send('开个玩笑而已么');
            }
        }, 'start', 1);

        $pm->start();
    }

    public function actionClose()
    {
        $pidFile = $this->config['options']['pid_file'];
        $masterPid = file_exists($pidFile) ? file_get_contents($pidFile) : null;
        var_dump($masterPid);
        if (!empty($masterPid)) {
            posix_kill($masterPid, SIGTERM);
            if (PHP_OS == 'Darwin') {
                //mac下.发送信号量无法触发shutdown.
                unlink($pidFile);
            }
        } else {
            print_r('master pid is null, maybe you delete the pid file we created. you can manually kill the master process with signal SIGTERM.'.PHP_EOL);
        }
    }

    public function actionReload()
    {
        $pidFile = $this->config['options']['pid_file'];
        $masterPid = file_exists($pidFile) ? file_get_contents($pidFile) : null;
        if (!empty($masterPid)) {
            posix_kill($masterPid, SIGUSR1); // reload all worker
            //                posix_kill($masterPid, SIGUSR2); // reload all task
        } else {
            print_r('master pid is null, maybe you delete the pid file we created. you can manually kill the master process with signal SIGUSR1.'.PHP_EOL);
        }
    }
}
