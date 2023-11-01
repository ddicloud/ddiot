<?php

namespace common\components;


use Yii;
use yii\web\Request;

class ExtendedRequest extends Request
{
    /**
     * @param $key
     * @param $default
     * @return array|mixed|object|null
     */
    public function input($key = null, $default = null): mixed
    {
        $getParams = $this->get();
        $postParams = $this->post();

        //头部bloc_id 与store_id 参数优先级低于自身请求体里面的参数
        $headerParams = [];
        if ($key === 'bloc_id' || $key === 'store_id'){
            $headerKey = str_replace('_','-',$key);
            $headerParams = Yii::$app->request->headers->get($headerKey);
        }

        $data = array_merge($headerParams,$getParams, $postParams);

        // 如果指定了 $key，则返回对应的值，否则返回整个合集
        if ($key !== null) {
            return $data[$key] ?? $default;
        }

        return $data;
    }
}
