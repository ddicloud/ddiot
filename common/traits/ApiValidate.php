<?php

use yii\base\DynamicModel;
use yii\base\InvalidConfigException;

trait ApiValidate {

    /**
     * 验证参数方法
     * @param array $rules 验证规则数组
     * @return array|object[]|string[]|true
     * @throws InvalidConfigException
     */
    public function validateParams(array $rules): array|true
    {
        global $_GPC;
        $validator = DynamicModel::validateData($_GPC, $rules);
        $validator->validate();
        if ($validator->validate()) {
            // 验证通过，执行接口逻辑
            return true;
        } else {
            // 验证失败，返回第一个错误信息
            $error = reset($validator->errors);
            return \common\helpers\ResultHelper::json(400,$error[0]);
        }
    }
}