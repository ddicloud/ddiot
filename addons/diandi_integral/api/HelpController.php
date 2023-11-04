<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-22 01:15:42
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-27 21:07:53
 */


namespace addons\diandi_integral\api;

use common\helpers\ResultHelper;
use Yii;
use api\controllers\AController;

/**
 * Class HelpController
 */
class HelpController extends AController
{
    public $modelClass = '\common\models\IntegralGoods';
    protected array $authOptional = ['detail', 'lists'];



    public function actionDetail(): array
    {
        return ResultHelper::json(200, '获取成功');
    }


    public function actionLists(): array
    {
        return ResultHelper::json(200, '获取成功');
    }
}
