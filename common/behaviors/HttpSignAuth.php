<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-16 09:05:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-16 09:06:51
 */

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Controller as ControllerAlias;
use yii\base\Exception;
use yii\web\Controller;

/**
 * sign 验证类.
 */
class HttpSignAuth extends Behavior
{
    public string $privateKey = '12345678';

    public string $signParam = 'sign';

    public function events(): array
    {
        return [ControllerAlias::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event): bool
    {
        //获取 sign
        $sign = Yii::$app->request->get($this->signParam, null);
        $getParams = Yii::$app->request->get();
        $postParams = Yii::$app->request->post();
        $params = array_merge($getParams, $postParams);
//        if (empty($sign) || !$this->checkSign($sign, $params)) {
//             $error = errorCode::getError('auth_error');
//             throw new Exception($error['msg'], $error['code']);
//        }

        return true;
    }

    private function checkSign($sign, $params): bool
    {
        unset($params[$this->signParam]);
        ksort($params);

        return md5($this->privateKey.implode(',', $params)) === $sign;
    }
}
