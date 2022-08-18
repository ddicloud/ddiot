<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-05 10:04:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-18 13:30:42
 */

namespace swooleService\components\http;

use console\controllers\BaseController;
use Swoole\Runtime;
use swooleService\interfaces\SwooleServer;
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
class HttpController extends BaseController implements SwooleServer
{
    public $server;

    public $addons;

    public $config;

    public function actions()
    {
        parent::actions();
        $confPath = Yii::getAlias('@addons/'.$this->addons.'/config/swoole_http.php');
        $CommonConfPath = Yii::getAlias('@common/config');
        if (file_exists($confPath)) {
            $config = require $confPath;
            $BaseConfig = yii\helpers\ArrayHelper::merge(
                [
                    'params' => yii\helpers\ArrayHelper::merge(
                        require($CommonConfPath.'/params.php'),
                        require($CommonConfPath.'/params-local.php'),
                    ),
                ],
                require Yii::getAlias('@swooleService/config/server.php'),
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
        Runtime::enableCoroutine(false);
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', getenv('PHP_ENV') === 'development' ? 'dev' : 'prod');
        $serverName = $this->server;
        $server = new $serverName($this->config);
        $server->start();
    }
}
