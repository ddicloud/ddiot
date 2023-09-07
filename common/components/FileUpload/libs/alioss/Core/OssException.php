<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:14:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-13 01:32:39
 */


namespace Alioss\Core;

/**
 * Class OssException
 *
 * OssClient在使用的时候，所抛出的异常，用户在使用OssClient的时候，要Try住相关代码，
 * try的Exception应该是OssException，其中会得到相关异常原因
 *
 * @package OSS\Core
 */
class OssException extends \Exception
{
    private array $details = array();

    function __construct($details)
    {
        if (is_array($details)) {
            $message = $details['code'] . ': ' . $details['message']
                     . ' RequestId: ' . $details['request-id'];
            parent::__construct($message);
            $this->details = $details;
        } else {
            $message = $details;
            parent::__construct($message);
        }
    }

    public function getHTTPStatus()
    {
        return $this->details['status'] ?? '';
    }

    public function getRequestId()
    {
        return $this->details['request-id'] ?? '';
    }

    public function getErrorCode()
    {
        return $this->details['code'] ?? '';
    }

    public function getErrorMessage()
    {
        return $this->details['message'] ?? '';
    }

    public function getDetails()
    {
        return $this->details['body'] ?? '';
    }
}
