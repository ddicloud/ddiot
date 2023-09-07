<?php

namespace Alioss\Result;

use Alioss\Core\OssException;
use Alioss\Model\CorsConfig;
use ErrorException;

class GetCorsResult extends Result
{
    /**
     * @return CorsConfig
     * @throws ErrorException
     */
    protected function parseDataFromResponse(): CorsConfig
    {
        $content = $this->rawResponse->body;
        $config = new CorsConfig();
        try {
            $config->parseFromXml($content);
        } catch (OssException $e) {
            throw new ErrorException($e->getMessage());
        }
        return $config;
    }

    /**
     * 根据返回http状态码判断，[200-299]即认为是OK, 获取bucket相关配置的接口，404也认为是一种
     * 有效响应
     *
     * @return bool
     */
    protected function isResponseOk(): bool
    {
        $status = $this->rawResponse->status;
        if ((int)(intval($status) / 100) == 2 || (int)(intval($status)) === 404) {
            return true;
        }
        return false;
    }

}