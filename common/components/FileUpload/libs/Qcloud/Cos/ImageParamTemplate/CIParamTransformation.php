<?php

namespace Qcloud\Cos\ImageParamTemplate;

class CIParamTransformation extends ImageTemplate{

    private array $tranParams;
    private string $tranString;
    private mixed $spilt;

    public function __construct($spilt = "|") {
        parent::__construct();
        $this->spilt = $spilt;
        $this->tranParams = array();
        $this->tranString = "";
    }

    public function addRule(ImageTemplate $template): void
    {
        if($template->queryString()){
            $this->tranParams[] = $template->queryString();
        }
    }

    public function queryString(): string
    {
        if($this->tranParams) {
            $this->tranString = implode($this->spilt, $this->tranParams);
        }
        return $this->tranString;
    }

    public function resetRule(): void
    {
        $this->tranParams = array();
        $this->tranString = "";
    }

    public function defineRule($value): void
    {
        $this->tranParams[] = $value;
    }
}
