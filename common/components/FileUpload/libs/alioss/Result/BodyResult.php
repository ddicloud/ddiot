<?php

namespace Alioss\Result;


/**
 * Class BodyResult
 * @package OSS\Result
 */
class BodyResult extends Result
{
    /**
     * @return string
     */
    protected function parseDataFromResponse(): string
    {
        return empty($this->rawResponse->body) ? "" : $this->rawResponse->body;
    }
}