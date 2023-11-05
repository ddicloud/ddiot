<?php

namespace common\components;


use Yii;
use yii\web\Request;

/**
 * @inheritdoc
 *
 * @property yii\web\Request Request
 */
class ExtendedRequest extends Request
{
    /**
     * @param $key
     * @param $default
     * @return array|object|null
     */
    public function input($key = null, $default = null): array|object|null
    {
        $getParams = $this->get();
        $postParams = $this->post();

        //头部bloc_id 与store_id 参数优先级低于自身请求体里面的参数
        $headerParams = [
            'bloc_id'=>Yii::$app->request->headers->get('bloc-id'),
            'store_id'=>Yii::$app->request->headers->get('store-id'),
            'access_token'=>Yii::$app->request->headers->get('access-token'),
        ];

        $data = array_merge($headerParams,$getParams, $postParams);

        // 如果指定了 $key，则返回对应的值，否则返回整个合集
        if ($key !== null) {
            return $data[$key] ?? $default;
        }

        return $data;
    }
}
