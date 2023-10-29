<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 Wednesday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-22 17:47:22
 */

namespace common\plugins\diandi_hub\api;

use Yii;
use api\controllers\AController;
use common\plugins\diandi_hub\models\enums\{
    TicketsRecordType,
};
use common\plugins\diandi_hub\services\TicketsRecordService;

/**
 * Class AddressController
 */
class TicketsRecordController extends AController
{
    use \addons\diandi_hub\components\ResultTrait;

    public $modelClass = '';

    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $data['send_id'] = \Yii::$app->user->identity->member_id??0;
        $data['type'] = TicketsRecordType::USER_SENDS;
        list($bool, $model) = TicketsRecordService::create($data);
        if ($bool) {
            $data['id'] = $model->id;
            return $this->_json($model->getAttributes(), '创建成功！');
        } else {
            return $this->_jsonError(current($model->getFirstErrors()), $model->getErrors());
        }
    }

    public function actionLists()
    {
        $where = [
            'and',
            ['=', 'tickets_id', Yii::$app->request->get('tickets_id', 0)],
            ['>', 'id', Yii::$app->request->get('id', -1)],
        ];
        $data = TicketsRecordService::getLists($this->_getPageInfo(), $where);
        if (isset($data['list'])) {
            $data['list'] = array_reverse($data['list']);
        } else {
            $data = array_reverse($data);
        }
        return $this->_json($data);
    }
}
