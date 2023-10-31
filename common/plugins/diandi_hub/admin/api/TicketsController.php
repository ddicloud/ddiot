<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 Wednesday
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:05:18
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\services\TicketsService;
use admin\controllers\AController;

/**
 * Class AddressController.
 */
class TicketsController extends AController
{
    use \addons\diandi_hub\components\ResultTrait;

    public $modelClass = '';

    public int $searchLevel = 0;

    public function actionCreate(): array
    {
        $data = \Yii::$app->request->post();
        $data['user_id'] = \Yii::$app->user->identity->user_id;
        list($bool, $model) = TicketsService::create($data);
        if ($bool) {
            $data['id'] = $model->id;

            return $this->_json($model->getAttributes(), '创建成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }

    public function actionLists()
    {
        $memberId = \Yii::$app->user->identity->user_id;
        $where = [
            'user_id' => $memberId ?: 0,
        ];

        return $this->_json(TicketsService::getLists($this->_getPageInfo(), $where));
    }

    public function actionUpdate($id): array
    {
        $temp = \Yii::$app->request->post();
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->user_id,
        ];
        $updateFields = ['name', 'mobile', 'relation', 'icon'];
        $data = [];
        foreach ($updateFields as $val) {
            isset($temp[$val]) && $data[$val] = $temp[$val];
        }
        list($bool, $model) = TicketsService::update($data, $where);
        if ($bool) {
            return $this->_json($model->getAttributes(), '修改成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }

    public function actionDelete($id): array
    {
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->user_id,
        ];
        list($bool, $model) = TicketsService::delete($where);
        if ($bool) {
            return $this->_json($model->getAttributes(), '删除成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }

    public function actionView($id): array
    {
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->user_id,
        ];

        return $this->_json(TicketsService::getDetail($where));
    }

    public function actionStatus($id)
    {
        $temp = \Yii::$app->request->post();
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->user_id,
        ];
        list($bool, $model) = TicketsService::updateStatus($where, $temp['status'] ?? -1);
        if ($bool) {
            return $this->_json($model->getAttributes(), '修改成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }
}
