<?php

namespace common\components;


use yii\web\Request;

class ExtendedRequest extends Request
{
    public function input($key = null, $default = null):array|object
    {
        $getParams = $this->get();
        $postParams = $this->post();

        $data = array_merge($getParams, $postParams);

        // 如果指定了 $key，则返回对应的值，否则返回整个合集
        if ($key !== null) {
            return $data[$key] ?? $default;
        }

        return $data;
    }
}
