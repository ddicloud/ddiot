<?php

namespace Qcloud\Cos\ImageParamTemplate;

class ImageWatermarkTemplate extends ImageTemplate
{

    private string $image;
    private string $gravity;
    private string $dx;
    private string $dy;
    private string $blogo;
    private string $scatype;
    private string $spcent;

    public function __construct() {
        parent::__construct();
        $this->image = "";
        $this->gravity = "";
        $this->dx = "";
        $this->dy = "";
        $this->blogo = "";
        $this->scatype = "";
        $this->spcent = "";
    }

    public function setImage($value): void
    {
        $this->image = "/image/" . $this->ciBase64($value);
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

    public function setBlogo($value): void
    {
        $this->blogo = "/blogo/" . $value;
    }

    public function setScatype($value): void
    {
        $this->scatype = "/scatype/" . $value;
    }

    public function setSpcent($value): void
    {
        $this->spcent = "/spcent/" . $value;
    }

    public function getImage(): string
    {
        return $this->image;
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

    public function getBlogo(): string
    {
        return $this->blogo;
    }

    public function getScatype(): string
    {
        return $this->scatype;
    }

    public function getSpcent(): string
    {
        return $this->spcent;
    }

    public function queryString(): string
    {
        $head = "watermark/1";
        $res = "";
        if($this->image) {
            $res .= $this->image;
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
        if($this->blogo) {
            $res .= $this->blogo;
        }
        if($this->scatype) {
            $res .= $this->scatype;
        }
        if($this->spcent) {
            $res .= $this->spcent;
        }
        if($res) {
            $res = $head . $res;
        }
        return $res;
    }

    public function resetRule(): void
    {
        $this->image = "";
        $this->gravity = "";
        $this->dx = "";
        $this->dy = "";
        $this->blogo = "";
        $this->scatype = "";
        $this->spcent = "";
    }
}
