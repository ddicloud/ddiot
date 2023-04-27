<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-04-25 23:10:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-27 14:20:08
 */

namespace common\components\EasySwoole;

use Yii;

class IotClient
{
    public $service; // 需要调用的服务名称
    public $module; // 需要调用的服务下的子模块名称
    public $action; // 需要调用的服务下的子模块的方法名称
    public $arg; // 需要传递的参数

    public $iot_ip = '82.156.131.85'; // 物联网服务器ip

    public $iot_rpc_port = '9600'; // 物联网服务器端口

    public function __construct($service, $module, $action, array $arg)
    {
        $this->service = $service;
        $this->module = $module;
        $this->action = $action;
        $this->arg = $arg;
    }

    public function buildTcpUrl()
    {
        return 'tcp://' . $this->iot_ip . ':' . $this->iot_rpc_port;
    }

    public function run()
    {
        $data = [
            'service' => $this->service,
            'module'  => $this->module,
            'action'  => $this->action,
            'arg'     => $this->arg,
        ];

        // Load server certificate and private key
        // file_get_contents
        $cert = Yii::getAlias("@addons/diandi_hotel/cert/certificate.pem");
        $key = Yii::getAlias("@addons/diandi_hotel/cert/private.key");

        $raw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $sslContext = stream_context_create([
            'ssl' => [
                'local_cert' => $cert,
                'local_pk' => $key,
            ],
        ]);


        // Create server socket
        $fp = stream_socket_server($this->buildTcpUrl(), $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $sslContext);

        // Accept incoming connections
        while ($conn = stream_socket_accept($fp)) {
            // Get client certificate
            $peerCert = stream_socket_get_name($conn, true);

            // Verify client certificate
            $result = openssl_x509_checkpurpose($peerCert, X509_PURPOSE_SSL_CLIENT, ['server_cert' => $cert]);

            if ($result === true) {
                // Client certificate is valid, handle request
                // tcp://127.0.0.1:9600（示例请求地址） 是 rpc 服务端的地址，这里是本地，所以使用 127.0.0.1
                // 开发者需要根据实际情况调整进行调用
                // $fp = stream_socket_client($this->buildTcpUrl());
                fwrite($fp, pack('N', strlen($raw)) . $raw); // pack 数据校验

                $try = 3;
                $data = fread($fp, 4);
                if (strlen($data) < 4 && $try > 0) {
                    $data .= fread($fp, 4);
                    $try--;
                    usleep(1);
                }

                // 做长度头部校验
                $len = unpack('N', $data);
                $data = '';
                $try = 3;
                if (strlen($data) < $len[1] && $try > 0) {
                    $data .= fread($fp, $len[1]);
                    $try--;
                    usleep(1);
                }

                if (strlen($data) != $len[1]) {
                    echo 'data error';
                } else {
                    $data = json_decode($data, true);
                    // 这就是服务端返回的结果
                    // var_dump($data);
                }

                fclose($fp);
                return $data;
            } else {
                // Client certificate is invalid, close connection
                fclose($conn);
                return [];
            }
        }
    }
}
