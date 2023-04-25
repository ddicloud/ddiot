<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-04-25 16:02:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-25 16:10:16
 */



namespace EasySwoole\Rpc\NodeManager;


use EasySwoole\Rpc\Server\ServiceNode;

interface NodeManagerInterface
{
    function getNodes(string $serviceName, ?int $version = null): array;
    function getNode(string $serviceName, ?int $version = null): ?ServiceNode;
    function failDown(ServiceNode $serviceNode): bool;
    function offline(ServiceNode $serviceNode): bool;
    function alive(ServiceNode $serviceNode): bool;
}
