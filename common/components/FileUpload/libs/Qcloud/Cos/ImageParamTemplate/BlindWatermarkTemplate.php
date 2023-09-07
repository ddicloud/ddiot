<?php

namespace Qcloud\Cos\ImageParamTemplate;

class BlindWatermarkTemplate extends ImageTemplate {
    private int $markType;
    private string $type;
    private string $image;
    private string $text;
    private string $level;

    public function __construct() {
        parent::__construct();
        $this->markType = 3;
        $this->type = "";
        $this->image = "";
        $this->text = "";
        $this->level = "";

    }

    public function setPick(): void
    {
        $this->markType = 4;
    }

    public function setType($value): void
    {
        $this->type = "/type/" . $value;
    }

    public function setImage($value): void
    {
        $this->image = "/image/" . $this->ciBase64($value);
    }

    public function setText($value): void
    {
        $this->text = "/text/" . $this->ciBase64($value);
    }

    public function setLevel($value): void
    {
        $this->level = "/level/" . $value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getLevel(): string
    {
        return $this->level;
    }


    public function queryString(): string
    {
        $head = "watermark/$this->markType";
        $res = "";
        if($this->type){
            $res .= $this->type;
        }
        if($this->image){
            $res .= $this->image;
        }
        if($this->text){
            $res .= $this->text;
        }
        if($this->level){
            $res .= $this->level;
        }
        if($res){
            $res = $head . $res;
        }
        return $res;
    }

    public function resetRule(): void
    {
        $this->markType = 3;
        $this->type = "";
        $this->image = "";
        $this->text = "";
        $this->level = "";
    }
}
