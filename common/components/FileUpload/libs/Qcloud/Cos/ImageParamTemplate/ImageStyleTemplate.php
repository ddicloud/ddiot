<?php

namespace Qcloud\Cos\ImageParamTemplate;

class ImageStyleTemplate extends ImageTemplate
{
    private $style;

    public function __construct() {
        parent::__construct();
        $this->style = "";
    }

    public function setStyle($styleName): void
    {
        $this->style = "style/" . $styleName;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    public function queryString(): string
    {
        $res = "";
        if($this->style) {
            $res = $this->style;
        }
        return $res;
    }

    public function resetRule(): void
    {
        $this->style = "";
    }
}
