<?php

namespace common\traits;

use Yii;
use yii\base\DynamicModel;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

trait ApiValidate {

    /**
     * 验证参数方法
     * @param array $rules 验证规则数组
     * @return array|object[]|string[]|bool
     * @throws InvalidConfigException
     * @throws ErrorException
     */
    public function validateParams(array $rules): array|bool
   {
        $data = Yii::$app->request->input();
        $validator = DynamicModel::validateData($data, $rules);
        $validator->validate();
        if ($validator->validate()) {
            // 验证通过，执行接口逻辑
            return true;
        } else {
            // 验证失败，返回第一个错误信息
            $error = reset($validator->errors);
            throw new ErrorException($error[0],400);
        }
    }
}