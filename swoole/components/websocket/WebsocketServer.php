<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-17 09:25:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-19 16:02:47
 */

namespace swooleService\components\websocket;

use common\helpers\loggingHelper;
use diandi\swoole\websocket\server\WebSocketServer as ServerWebSocketServer;
use swooleService\models\SwooleMember;
use swooleService\servers\AccessTokenService;

class WebsocketServer extends ServerWebSocketServer
{
    public function onHandshake(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        loggingHelper::writeLog('swooleService', 'onHandshake', '开始权限校验处理', [
            'header' => $request->header,
        ]);

        /* 此处自定义握手规则 返回 false 时中止握手 */
        if (!$this->customHandShake($request, $response)) {
            $response->end();

            return false;
        }

        /* 此处是  RFC规范中的WebSocket握手验证过程 必须执行 否则无法正确握手 */
        if ($this->secWebsocketAccept($request, $response)) {
            $response->end();

            return true;
        }

        $response->end();

        return false;
    }

    /**
     * @return bool
     */
    protected function customHandShake(\Swoole\Http\Request $request, \Swoole\Http\Response $response): bool
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
    protected function secWebsocketAccept(\Swoole\Http\Request $request, \Swoole\Http\Response $response): bool
    {
        global $_GPC;
        loggingHelper::writeLog('swooleService', 'onHandshake', '开始权限校验处理', [
            '_GPC' => $_GPC,
            'get' => $request->get,
        ]);
        // ws rfc 规范中约定的验证过程
        if (!isset($request->header['sec-websocket-key'])) {
            // 需要 Sec-WebSocket-Key 如果没有拒绝握手
            var_dump('shake fai1 3');

            return false;
        }
        if (0 === preg_match('#^[+/0-9A-Za-z]{21}[AQgw]==$#', $request->header['sec-websocket-key'])
            || 16 !== strlen(base64_decode($request->header['sec-websocket-key']))
        ) {
            //不接受握手
            var_dump('shake fai1 4');

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
        foreach ($headers as $key => $val) {
            $response->header($key, $val);
        }


        $accessToken = $request->get['access_token'];
        if (!empty($token)) {
            var_dump('accessToken 没有设置');
            return false;
        } else {
            if($this->checkAccess($accessToken)){
                $response->status(101);
                return true;
            }else{
                var_dump('accessToken 校验失败');
                return false;
            }
        }

        // 接受握手 还需要101状态码以切换状态
        $response->status(101);
        var_dump('shake success at fd :'.$request->fd);

        return true;
    }

    public function checkAccess($accessToken)
    {
        $AccessTokenService = new AccessTokenService();
        $memberToken = $AccessTokenService->findByAccessToken($accessToken);

        $SwooleMember = SwooleMember::find()->where(['id' => $memberToken['swoole_member_id']])->one();

        if(empty($SwooleMember)){
            return false;
        }else{
            $member = $AccessTokenService->getAccessToken($SwooleMember, 1);
            loggingHelper::writeLog('swooleService', 'checkAccess', '用户验证', [
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
}
