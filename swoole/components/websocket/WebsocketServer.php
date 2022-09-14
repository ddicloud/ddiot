<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-17 09:25:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-14 18:13:32
 */

namespace ddswoole\components\websocket;

use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use ddswoole\interfaces\InteractsWithSwooleTable;
use ddswoole\interfaces\SocketServer;
use ddswoole\models\SwooleMember;
use ddswoole\servers\AccessTokenService;
use ddswoole\servers\DebugService;
use diandi\swoole\web\Application;
use diandi\swoole\websocket\Context;
use diandi\swoole\websocket\server\WebSocketServer as ServerWebSocketServer;
use Swoole\Http\Request;
use Yii;

class WebsocketServer extends ServerWebSocketServer implements SocketServer
{
    use InteractsWithSwooleTable;

    public $onWorkStartCallable;

    private $application;

    private $config;

    public $channelNum = 20;

    /**
     * 重新实例化application.
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
    public function __construct($config, $callable)
    {
        parent::__construct($config);
        $this->onWorkStartCallable = $callable;
        $this->config = $config['app'];
    }

    public function run()
    {
        $this->application = new Application($this->config);
        if (!empty($this->tables) && is_array($this->tables)) {
            $this->prepareTables($this->tables);
        }
        // 注入上下文
        Yii::$app->setComponents([
            'context' => [
                'class' => Context::class,
            ],
        ]);
    }

    /**
     * 增加监听.
     *
     * @return void
     * @date 2022-09-02
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function addlistenerPort($channelListener)
    {
    }

    /**
     * 上下文初始化.
     *
     * @param [type] $type
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
    public function ContextInit($type)
    {
        // code...
    }

    public function heartbeat($ws, $message)
    {
        if ($message['type'] === 'HEARTBEAT') {
            // 心跳
            $ws->push(ResultHelper::socketJson('HEARTBEAT', 200, '心跳成功'));

            return false;
        }

        return true;
    }

    /**
     * 工作进程启动时实例化框架.
     *
     * @param \Swoole\Http\Server $server
     * @param int                 $workerId
     *
     * @throws InvalidConfigException
     */
    public function onWorkerStart(\Swoole\WebSocket\Server $server, $workerId)
    {
        if ($this->onWorkStartCallable) {
            call_user_func_array([$this->onWorkStartCallable, 'bootstrap'], [$this->application]);
            // $this->onWorkStartCallable = null;
        }
    }

    /**
     * 握手校验处理，返回true表示成功
     *
     * @return void
     * @date 2022-09-14
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function checkUpgrade(\Swoole\Http\Request $request, \Swoole\Http\Response $ws)
    {
        return $this->onHandshake($request, $ws);
    }

    public function onHandshake(\Swoole\Http\Request $request, \Swoole\Http\Response $ws)
    {
        /* 此处自定义握手规则 返回 false 时中止握手 */
        if (!$this->customHandShake($request, $ws)) {
            return false;
        }

        /* 此处是  RFC规范中的WebSocket握手验证过程 必须执行 否则无法正确握手 */
        if ($this->secWebsocketAccept($request, $ws)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function customHandShake(\Swoole\Http\Request $request, \Swoole\Http\Response $ws): bool
    {
        /**
         * 这里可以通过 http request 获取到相应的数据
         * 进行自定义验证后即可
         * (注) 浏览器中 JavaScript 并不支持自定义握手请求头 只能选择别的方式 如get参数.
         */
        $headers = $request->header;
        $cookie = $request->cookie;
        // if (如果不满足我某些自定义的需求条件，返回false，握手失败) {
        //    return false;
        // }
        return true;
    }

    /**
     * RFC规范中的WebSocket握手验证过程
     * 以下内容必须强制使用.
     *
     * @return bool
     */
    protected function secWebsocketAccept(\Swoole\Http\Request $request, \Swoole\Http\Response $ws): bool
    {
        // ws rfc 规范中约定的验证过程
        if (!isset($request->header['sec-websocket-key'])) {
            // 需要 Sec-WebSocket-Key 如果没有拒绝握手
            DebugService::consoleWrite('shake fai1 3');

            return false;
        }
        if (0 === preg_match('#^[+/0-9A-Za-z]{21}[AQgw]==$#', $request->header['sec-websocket-key'])
            || 16 !== strlen(base64_decode($request->header['sec-websocket-key']))
        ) {
            //不接受握手
            DebugService::consoleWrite('shake fai1 4');

            return false;
        }

        $key = base64_encode(sha1($request->header['sec-websocket-key'].'258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        $headers = [
            'Upgrade' => 'websocket',
            'Connection' => 'Upgrade',
            'Sec-WebSocket-Accept' => $key,
            'Sec-WebSocket-Version' => '13',
            'KeepAlive' => 'off',
        ];

        if (isset($request->header['sec-websocket-protocol'])) {
            $headers['Sec-WebSocket-Protocol'] = $request->header['sec-websocket-protocol'];
        }
        // 发送验证后的header
        $ws->header = $headers;

        if (empty($request->server['query_string'])) {
            DebugService::consoleWrite('请检查websocket地址是否正确');

            return false;
        }

        $options = $this->getRoute($request->server['query_string']);
        $accessToken = $options['access_token'];
        if (empty($accessToken)) {
            DebugService::consoleWrite('accessToken 没有设置');

            return false;
        } else {
            if ($this->checkAccess($accessToken)) {
                return true;
            } else {
                DebugService::consoleWrite('accessToken 校验失败');

                return false;
            }
        }

        // 接受握手 还需要101状态码以切换状态
        // $ws->status(101);
        DebugService::consoleWrite('shake success at fd :'.$request->fd);

        return true;
    }

    public function checkAccess($accessToken)
    {
        $AccessTokenService = new AccessTokenService();
        $memberToken = $AccessTokenService->findByAccessToken($accessToken);

        $SwooleMember = SwooleMember::find()->where(['id' => $memberToken['swoole_member_id']])->one();

        if (empty($SwooleMember)) {
            return false;
        } else {
            $member = $AccessTokenService->getAccessToken($SwooleMember, 1);
            loggingHelper::writeLog('ddswoole', 'checkAccess', '用户验证', [
                'member' => $member,
            ]);

            if (!empty($member)) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * 解析路由参数.
     *
     * @return void
     * @date 2022-09-14
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function getRoute($query_string)
    {
        parse_str($query_string, $arr);

        return  $arr;
    }
}
