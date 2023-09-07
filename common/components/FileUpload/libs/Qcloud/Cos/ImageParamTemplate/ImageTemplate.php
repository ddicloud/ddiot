<?php

namespace Qcloud\Cos\ImageParamTemplate;

class ImageTemplate
{

    public function __construct() {
    }

    public function queryString(): string
    {
        return "";
    }

    public function ciBase64($value): array|string
    {
        return  str_replace("/", "_", str_replace("+", "-", base64_encode($value)));
    }
}
