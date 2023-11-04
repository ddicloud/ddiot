<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-02 18:39:18
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\NoticeService;
use api\controllers\AController;
use common\helpers\loggingHelper;

class NoticeController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['*'];

    public function actionOrderobs(): void
   {
        $data =\Yii::$app->request->input('data');
        $store_id =\Yii::$app->request->input('store_id',0);

        loggingHelper::writeLog('diandi_tea', 'Noticeobs', '1', $_GPC);

        NoticeService::Subscribe($data, $store_id);
    }

    public function actionRenewobs(): void
   {
        $data =\Yii::$app->request->input('data');
        $store_id =\Yii::$app->request->input('store_id',0);
        loggingHelper::writeLog('diandi_tea', 'Renewobs', '1', $_GPC);

        NoticeService::Renew($data, $store_id);
    }
}
