<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 Wednesday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-22 17:09:39
 */

namespace common\plugins\diandi_hub\api;

use Yii;
use api\controllers\AController;
use common\plugins\diandi_hub\services\TicketsService;

/**
 * Class AddressController
 */
class TicketsController extends AController
{
    use \addons\diandi_hub\components\ResultTrait;

    public $modelClass = '';

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();
        $data['user_id'] = \Yii::$app->user->identity->member_id??0;
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
        $memberId = \Yii::$app->user->identity->member_id??0;
        $where = [
            'user_id' => $memberId ?: 0,
        ];
        return $this->_json(TicketsService::getLists($this->_getPageInfo(), $where));
    }

    public function actionUpdate($id)
    {
        $temp = \Yii::$app->request->post();
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->member_id,
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

    public function actionDelete($id)
    {
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->member_id,
        ];
        list($bool, $model) = TicketsService::delete($where);
        if ($bool) {
            return $this->_json($model->getAttributes(), '删除成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }

    public function actionView($id)
    {
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->member_id,
        ];
        return $this->_json(TicketsService::getDetail($where));
    }

    public function actionStatus($id)
    {
        $temp = \Yii::$app->request->post();
        $where = [
            'id' => $id,
            'user_id' => \Yii::$app->user->identity->member_id,
        ];
        list($bool, $model) = TicketsService::updateStatus($where, $temp['status'] ?? -1);
        if ($bool) {
            return $this->_json($model->getAttributes(), '修改成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }
}
