<?php

/**
 * @Author: Radish
 * @Date:   2022-06-23 09:14:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-07 18:36:32
 */

namespace common\plugins\diandi_website\components;

use common\helpers\ResultHelper;
use Yii;

trait ResultTrait
{
    private function getPageInfo(): array
    {
        $pageInfo = [];
        $limitStart = Yii::$app->request->input('limit_start') ?? -1;
        if ($limitStart == 1) {
            $pageInfo = [
                'limit_start' => 1,
                'pageSize' => Yii::$app->request->input('pageSize') ?? 10,
                'page' => Yii::$app->request->input('page'),
            ];
        }
        return $pageInfo;
    }

    private function _json($data, $code = 200, $message = "请求成功!"): array
    {
        if ($data === \addons\diandi_website\components\ResultServicesTrait::$storeInvalid) {
            return ResultHelper::json(400, '请求失败！', '无效的商户信息');
        }
        return ResultHelper::json($code, $message, $data);
    }

    private function _fillWhere($fields = []): array
    {
       $where = [];
       $data = Yii::$app->request->input();

        foreach ($fields as $field) {
            if (isset($data[$field]) && $data[$field]) {
                $where[$field] = $data[$field];
            }
        }
        return $where;
    }
}
