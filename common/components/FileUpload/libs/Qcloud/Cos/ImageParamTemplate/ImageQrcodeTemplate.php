<?php

namespace Qcloud\Cos\ImageParamTemplate;

class ImageQrcodeTemplate extends ImageTemplate
{
    private $mode;

    public function __construct() {
        parent::__construct();
        $this->mode = "";
    }

    public function setMode($mode): void
    {
        $this->mode = "/cover/" . $mode;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function queryString(): string
    {
        $head = "QRcode";
        $res = "";
        if($this->mode) {
            $res .= $this->mode;
        }
        if($res) {
            $res = $head . $res;
        }
        return $res;
    }

    public function resetRule(): void
    {
        $this->mode = "";
    }
}
