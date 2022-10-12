<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-05 10:04:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-12 21:13:59
 */

namespace ddswoole\components\websocket;

use console\controllers\BaseController;
use ddswoole\bootstrap\Loader;
use ddswoole\interfaces\controllers\SwooleInterfaceController;
use diandi\swoole\websocket\Context;
use function Swoole\Coroutine\run;
use Swoole\Process\Manager;
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
        $pm = new Manager();
        $proc1 = $pm->add(function (Pool $pool, int $workerId) use ($serverName) {
            run(function () use ($serverName) {
                //让每个OnWorkerStart回调都自动创建一个协程
                $Loader = new Loader();
                $context = new Context();
                $server = new $serverName($this->config, $Loader, $context);

                return  $server->run();
            });
        });

        $pm->add(function (Pool $pool, int $workerId) {
            echo $workerId.PHP_EOL;
        });

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
