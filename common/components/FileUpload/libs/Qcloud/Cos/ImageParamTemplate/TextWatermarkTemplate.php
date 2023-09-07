<?php

namespace Qcloud\Cos\ImageParamTemplate;

/**
 * Parses default XML exception responses
 */
class TextWatermarkTemplate extends ImageTemplate
{
    private string $text;
    private string $font;
    private string $fontsize;
    private string $fill;
    private string $dissolve;
    private string $gravity;
    private string $dx;
    private string $dy;
    private string $batch;
    private string $degree;

    public function __construct() {
        parent::__construct();
        $this->text = "";
        $this->font = "";
        $this->fontsize = "";
        $this->fill = "";
        $this->dissolve = "";
        $this->gravity = "";
        $this->dx = "";
        $this->dy = "";
        $this->batch = "";
        $this->degree = "";
    }

    public function setText($value): void
    {
        $this->text = "/text/" . $this->ciBase64($value);
    }

    public function setFont($value): void
    {
        $this->font = "/font/" . $this->ciBase64($value);
    }

    public function setFontsize($value): void
    {
        $this->fontsize = "/fontsize/" . $value;
    }

    public function setFill($value): void
    {
        $this->fill = "/fill/" . $this->ciBase64($value);
    }

    public function setDissolve($value): void
    {
        $this->dissolve = "/dissolve/" . $value;
    }

    public function setGravity($value): void
    {
        $this->gravity = "/gravity/" . $value;
    }

    public function setDx($value): void
    {
        $this->dx = "/dx/" . $value;
    }

    public function setDy($value): void
    {
        $this->dy = "/dy/" . $value;
    }

    public function setBatch($value): void
    {
        $this->batch = "/batch/" . $value;
    }

    public function setDegree($value): void
    {
        $this->degree = "/degree/" . $value;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getFont(): string
    {
        return $this->font;
    }

    public function getFontsize(): string
    {
        return $this->fontsize;
    }

    public function getFill(): string
    {
        return $this->fill;
    }

    public function getDissolve(): string
    {
        return $this->dissolve;
    }

    public function getGravity(): string
    {
        return $this->gravity;
    }

    public function getDx(): string
    {
        return $this->dx;
    }

    public function getDy(): string
    {
        return $this->dy;
    }

    public function getBatch(): string
    {
        return $this->batch;
    }

    public function getDegree(): string
    {
        return $this->degree;
    }

    public function queryString(): string
    {
        $head = "watermark/2";
        $res = "";
        if($this->text) {
            $res .= $this->text;
        }
        if($this->font) {
            $res .= $this->font;
        }
        if($this->fontsize) {
            $res .= $this->fontsize;
        }
        if($this->fill) {
            $res .= $this->fill;
        }
        if($this->dissolve) {
            $res .= $this->dissolve;
        }
        if($this->gravity) {
            $res .= $this->gravity;
        }
        if($this->dx) {
            $res .= $this->dx;
        }
        if($this->dy) {
            $res .= $this->dy;
        }
        if($this->batch) {
            $res .= $this->batch;
        }
        if($this->degree) {
            $res .= $this->degree;
        }
        if($res) {
            $res = $head . $res;
        }
        return $res;
    }

    public function resetRule(): void
    {
        $this->text = "";
        $this->font = "";
        $this->fontsize = "";
        $this->fill = "";
        $this->dissolve = "";
        $this->gravity = "";
        $this->dx = "";
        $this->dy = "";
        $this->batch = "";
        $this->degree = "";
    }
}
