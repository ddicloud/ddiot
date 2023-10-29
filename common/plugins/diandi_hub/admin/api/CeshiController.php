<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:50:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:34
 */

namespace common\plugins\diandi_hub\admin\api;

use admin\controllers\AController;
use Yii;

/**
 * Class CategoryController.
 */
class CeshiController extends AController
{
    public $modelClass = '\common\models\DdCategory';
    protected array $authOptional = ['list'];

    public int $searchLevel = 0;

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    public function actionSms()
    {
        global $_GPC;
        $mobile = $_GPC['mobile'];
        Yii::$app->cache->set($mobile.'_code', '147852');
    }
}
