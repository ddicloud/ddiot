<?php

namespace Qcloud\Cos\ImageParamTemplate;

/**
 * Parses default XML exception responses
 */
class ImageViewTemplate extends ImageTemplate
{
    private string $mode;
    private string $width;
    private string $height;
    private string $format;
    private string $quality;


    public function __construct() {
        parent::__construct();
        $this->mode = "";
        $this->width = "";
        $this->height = "";
        $this->format = "";
        $this->quality = "";
    }

    public function setMode($value): void
    {
        $this->mode = "/" . $value;
    }

    public function setWidth($value): void
    {
        $this->width = "/w/" . $value;
    }

    public function setHeight($value): void
    {
        $this->height = "/h/" . $value;
    }

    public function setFormat($value): void
    {
        $this->format = "/format/" . $value;
    }

    public function setQuality($qualityType, $qualityValue, $force = 0): void
    {
        if($qualityType == 1){
            $this->quality = "/q/$qualityValue" ;
            if($force){
                $this->quality .= "!";
            }
        }else if($qualityType == 2){
            $this->quality = "/rq/$qualityValue" ;
        }else if ($qualityType == 3){
            $this->quality = "/lq/$qualityValue" ;
        }
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function queryString(): string
    {
        $head = "imageView2";
        $res = "";
        if($this->mode) {
            $res .= $this->mode;
        }
        if($this->width) {
            $res .= $this->width;
        }
        if($this->height) {
            $res .= $this->height;
        }
        if($this->format) {
            $res .= $this->format;
        }
        if($this->quality) {
            $res .= $this->quality;
        }
        if($res) {
            $res = $head . $res;
        }
        return $res;
    }

    public function resetRule(): void
    {
        $this->mode = "";
        $this->width = "";
        $this->height = "";
        $this->format = "";
        $this->quality = "";
    }
}
