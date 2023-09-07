<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:14:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-26 19:01:22
 */


namespace Alioss\Http;

/**
 * Container for all response-related methods.
 */
class ResponseCore
{
    /**
     * Stores the HTTP header information.
     */
    public array $header;

    /**
     * Stores the SimpleXML response.
     */
    public string $body;

    /**
     * Stores the HTTP response code.
     */
    public ?int $status;

    /**
     * Constructs a new instance of this class.
     *
     * @param array $header (Required) an Associative array of HTTP headers (typically returned by <RequestCore::get_response_header()>).
     * @param string $body (Required) XML-formatted response from AWS.
     * @param integer|null $status (Optional) HTTP response status code from the request.
     * @return ResponseCore Contains an <php:array> `header` property (HTTP headers as an associative array), a <php:SimpleXMLElement> or <php:string> `body` property, and an <php:integer> `status` code.
     */
    public function __construct(array $header, string $body, int $status = null)
    {
        $this->header = $header;
        $this->body = $body;
        $this->status = $status;

        return $this;
    }

    /**
     * Did we receive the status code we expected?
     *
     * @param array|integer $codes (Optional) The status code(s) to expect. Pass an <php:integer> for a single acceptable value, or an <php:array> of integers for multiple acceptable values.
     * @return boolean Whether we received the expected status code or not.
     */
    public function isOK(array|int $codes = array(200, 201, 204, 206)): bool
    {
        if (is_array($codes)) {
            return in_array($this->status, $codes);
        }

        return $this->status === $codes;
    }
}