<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-20 13:15:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-26 11:04:22
 */

namespace common\plugins\diandi_hub\admin\conf;

use common\plugins\diandi_hub\models\config\HubConfig;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * PriceConfController implements the CRUD actions for HubPriceConf model.
 */
class ConfigController extends AController
{
    public function actionInfo()
    {
        $model = new HubConfig();
        $detail = $model->findOne(1);

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionForm()
    {
        global $_GPC;

        $model = new HubConfig();

        $conf = $model->find()->asArray()->one();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $HubConfig = $_GPC;
            $Data = [
                    'min_money' => floatval($HubConfig['min_money']),
                    'max_num' => floatval($HubConfig['max_num']),
                    'max_money' => floatval($HubConfig['max_money']),
                    'user_radio' => floatval($HubConfig['user_radio']),

                    'store_min_money' => floatval($HubConfig['store_min_money']),
                    'store_max_num' => floatval($HubConfig['store_max_num']),
                    'store_max_money' => floatval($HubConfig['store_max_money']),

                    'store_radio' => floatval($HubConfig['store_radio']),
                    'user_integral_name' => trim($HubConfig['user_integral_name']),
                    'is_credit1' => intval($HubConfig['is_credit1']),
                    'is_credit2' => intval($HubConfig['is_credit2']),
                    'is_credit3' => intval($HubConfig['is_credit3']),
                    'credit1_name' => trim($HubConfig['credit1_name']),
                    'credit2_name' => trim($HubConfig['credit2_name']),
                    'credit3_name' => trim($HubConfig['credit3_name']),

                    'kd_id' => $HubConfig['kd_id'],
                    'kd_key' => $HubConfig['kd_key'],
                    'h5_url' => $HubConfig['h5_url'],
                    'onecode' => intval($HubConfig['onecode']),
                    'shareimg' => trim($HubConfig['shareimg']),
                    'myshareimg' => trim($HubConfig['myshareimg']),
                ];

            if (!empty($conf)) {
                $Res = $model->updateAll($Data, ['id' => $conf['id']]);
                if ($Res) {
                    return ResultHelper::json(200, '修改成功');
                } else {
                    $msg = ErrorsHelper::getModelError($model);

                    return ResultHelper::json(400, $msg, $Res);
                }
            } else {
                if ($model->save()) {
                    return ResultHelper::json(200, '保存成功');
                } else {
                    $msg = ErrorsHelper::getModelError($model);

                    return ResultHelper::json(400, $msg);
                }
            }

            return ResultHelper::json(200, '修改成功');
        }
    }
}
