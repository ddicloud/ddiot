<?php

namespace Alioss\Result;


/**
 * Class PutSetDeleteResult
 * @package OSS\Result
 */
class PutSetDeleteResult extends Result
{
    /**
     * @return null
     */
    protected function parseDataFromResponse(): mixed
    {
        return null;
    }
}