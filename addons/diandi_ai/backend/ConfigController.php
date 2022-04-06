<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 23:43:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-23 11:19:20
 */

namespace addons\diandi_ai\backend;

use backend\controllers\BaseController;
use addons\diandi_ai\models\forms\Baidu;
use diandi\addons\models\Bloc;
use Yii;

/**
 * Class SiteController.
 */
class ConfigController extends BaseController
{
    public $modelSearchName = "";

    public function actions()
    {
        global $_GPC;
        $bloc_id = Yii::$app->params['bloc_id'];

        $bloc = Bloc::findOne($bloc_id);
    }

    public function actionBaidu()
    {
        global $_GPC;

        $model = new Baidu();
        $bloc_id = Yii::$app->params['bloc_id'];

        if (Yii::$app->request->isPost) {
            $model->load($_GPC);
            $Res = $model->saveConf($bloc_id);
            if ($Res['code'] == 200) {
                Yii::$app->session->setFlash('success', $Res['message']);
            } else {
                Yii::$app->session->setFlash('error', $Res['message']);
            }
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('baidu', [
            'model' => $model,
        ]);
    }
}
