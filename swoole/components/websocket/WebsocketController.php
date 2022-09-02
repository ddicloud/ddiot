<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-05 10:04:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-02 20:18:13
 */

namespace ddswoole\components\websocket;

use console\controllers\BaseController;
use ddswoole\bootstrap\Loader;
use ddswoole\interfaces\SwooleServer;
use Swoole\Runtime;
use Yii;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\CloseFrame;
use Swoole\Coroutine\Http\Server;
use function Swoole\Coroutine\run;


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
class WebsocketController extends BaseController implements SwooleServer
{
    public $server;

    public $addons;

    public $config;

    public function actions()
    {
        parent::actions();
        $confPath = Yii::getAlias('@addons/' . $this->addons . '/config/swoole_websocket.php');
        $CommonConfPath = Yii::getAlias('@common/config');
        if (file_exists($confPath)) {
            $config = require $confPath;
            $BaseConfig = yii\helpers\ArrayHelper::merge(
                [
                    'app' => [
                        'params' => yii\helpers\ArrayHelper::merge(
                            require ($CommonConfPath . '/params.php'),
                            require ($CommonConfPath . '/params-local.php'),
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
            throw new \Exception('配置文件不存在：' . $confPath);
        }
    }

    public function actionRun()
    {   
        defined('COROUTINE_ENV') or define('COROUTINE_ENV', true);
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', getenv('PHP_ENV') === 'development' ? 'dev' : 'prod');
        go(function(){
            $serverName = $this->server;
            $Loader = new Loader();
            $server = new $serverName($this->config,$Loader);
            $server->run();
        });
       
    }

    public function actionRun1()
    {
        go(function () {
            $server = new Server('127.0.0.1', 9505, false);
            $server->handle('/websocket', function (Request $request, Response $ws) {
                $ws->upgrade();
                while (true) {
                    $frame = $ws->recv();
                    if ($frame === '') {
                        $ws->close();
                        break;
                    } else if ($frame === false) {
                        echo 'errorCode: ' . swoole_last_error() . "\n";
                        $ws->close();
                        break;
                    } else {
                        if ($frame->data == 'close' || get_class($frame) === CloseFrame::class) {
                            $ws->close();
                            break;
                        }
                        $ws->push("Hello {$frame->data}!");
                        $ws->push("How are you, {$frame->data}?");
                    }
                }
            });


            $server->start();
        });

    }
}
