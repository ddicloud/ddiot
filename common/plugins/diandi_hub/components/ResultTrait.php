<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 15:06:38
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-21 15:06:47
 */

namespace common\plugins\diandi_hub\components;

use common\helpers\ResultHelper;

trait ResultTrait
{
    private function _getPageInfo()
    {
        global $_GPC;
        $pageInfo = [];
        $limitStart = $_GPC['limit_state'] ?? -1;
        if ($limitStart == 1) {
            $pageInfo = [
                'limit_state' => 1,
                'pageSize' => $_GPC['pageSize'] ?? 10,
                'page' => $_GPC['page'] > 0 ? $_GPC['page'] - 1 : 0,
            ];
        }
        return $pageInfo;
    }

    private function _json($data, $message = "success", $code = 200)
    {
        if ($data === \addons\diandi_wristband\components\ResultServicesTrait::$storeInvalid) {
            return ResultHelper::json(400, '请求失败！', '无效的商户信息');
        }
        return ResultHelper::json($code, $message, $data);
    }

    private function _jsonError($message = '', $data = [], $code = 400)
    {
        !$message && $message = '未知错误！';
        return $this->_json($data, $message, $code);
    }

    private function _fillWhere($fields = [])
    {
        global $_GPC;
        $where = [];
        foreach ($fields as $field) {
            if (isset($_GPC[$field]) && $_GPC[$field]) {
                $where[$field] = $_GPC[$field];
            }
        }
        return $where;
    }
}
