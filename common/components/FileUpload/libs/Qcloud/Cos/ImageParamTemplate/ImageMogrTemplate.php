<?php

namespace Qcloud\Cos\ImageParamTemplate;

class ImageMogrTemplate extends ImageTemplate
{
    private array $tranParams;
    private string $tranString;

    public function __construct() {
        parent::__construct();
        $this->tranParams = array();
        $this->tranString = "";
    }

    public function thumbnailByScale($widthScale): void
    {
        $this->tranParams[] = "/thumbnail/!" . $widthScale . "p";
    }

    public function thumbnailByWidthScale($heightScale): void
    {
        $this->tranParams[] = "/thumbnail/!" . $heightScale . "px";
    }

    public function thumbnailByHeightScale($scale): void
    {
        $this->tranParams[] = "/thumbnail/!x" . $scale . "p";
    }

    public function thumbnailByWidth($width): void
    {
        $this->tranParams[] = "/thumbnail/" . $width . "x";
    }

    public function thumbnailByHeight($height): void
    {
        $this->tranParams[] = "/thumbnail/x" . $height;
    }

    public function thumbnailByMaxWH($maxW, $maxH): void
    {
        $this->tranParams[] = "/thumbnail/" . $maxW . "x" . $maxH;
    }

    public function thumbnailByMinWH($minW, $minH): void
    {
        $this->tranParams[] = "/thumbnail/!" . $minW . "x" . $minH . "r" ;
    }

    public function thumbnailByWH($width, $height): void
    {
        $this->tranParams[] = "/thumbnail/" . $width  . "x" . $height . "!";
    }

    public function thumbnailByPixel($pixel): void
    {
        $this->tranParams[] = "/thumbnail/" . $pixel . "@";
    }

    public function cut($width, $height, $dx, $dy): void
    {
        $this->tranParams[] = "/cut/" . $width . "x" . "$height" . "x" . $dx . "x" . $dy;
    }

    public function cropByWidth($width, $gravity = ""): void
    {
        $temp = "/crop/" . $width . "x";
        if($gravity){
            $temp .= "/gravity/" . $gravity;
        }
        $this->tranParams[] = $temp;
    }

    public function cropByHeight($height, $gravity = ""): void
    {
        $temp = "/crop/x" . $height;
        if($gravity){
            $temp .= "/gravity/" . $gravity;
        }
        $this->tranParams[] = $temp;
    }

    public function cropByWH($width, $height, $gravity = ""): void
    {
        $temp = "/crop/" . $width . "x" . $height;
        if($gravity){
            $temp .= "/gravity/" . $gravity;
        }
        $this->tranParams[] = $temp;
    }

    public function iradius($radius): void
    {
        $this->tranParams[] = "/iradius/" . $radius;
    }

    public function rradius($radius): void
    {
        $this->tranParams[] = "/rradius/" . $radius;
    }

    public function scrop($width, $height): void
    {
        $this->tranParams[] = "/scrop/" . $width . "x" . $height;
    }

    public function rotate($degree): void
    {
        $this->tranParams[] = "/rotate/" . $degree;
    }

    public function autoOrient(): void
    {
        $this->tranParams[] = "/rotate/auto-orient";
    }

    public function format($format): void
    {
        $this->tranParams[] = "/format/" . $format;
    }

    public function gifOptimization($frameNumber): void
    {
        $this->tranParams[] = "/cgif/" . $frameNumber;
    }

    public function jpegInterlaceMode($mode): void
    {
        $this->tranParams[] = "/interlace/" . $mode;
    }

    public function quality($value, $force = 0): void
    {
        $temp = "/quality/" . $value;
        if($force){
            $temp .= "!";
        }
        $this->tranParams[] = $temp;
    }

    public function lowestQuality($value): void
    {
        $this->tranParams[] = "/lquality/" . $value;
    }

    public function relativelyQuality($value): void
    {
        $this->tranParams[] = "/rquality/" . $value;
    }

    public function blur($radius, $sigma): void
    {
        $this->tranParams[] = "/blur/" . $radius . "x" . $sigma;
    }

    public function bright($value): void
    {
        $this->tranParams[] = "/bright/" . $value;
    }

    public function contrast($value): void
    {
        $this->tranParams[] = "/contrast/" . $value;
    }

    public function sharpen($value): void
    {
        $this->tranParams[] = "/sharpen/" . $value;
    }

    public function strip(): void
    {
        $this->tranParams[] = "/strip";
    }

    public function queryString(): string
    {
        if($this->tranParams) {
            $this->tranString = "imageMogr2" . implode("", $this->tranParams);
        }
        return $this->tranString;
    }

    public function resetRule(): void
    {
        $this->tranString = "";
        $this->tranParams = array();
    }
}
