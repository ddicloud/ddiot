<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-26 02:02:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-31 22:36:34
 */
 

namespace common\helpers;

use Yii;
use yii\base\Model;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class ErrorsHelper extends BaseObject
{
    /**
     * function_description.
     *
     * @param int|null post
     * @return string
     * @throws NotFoundHttpException
     */
    public static function getModelError($model)
    {
        $errors = $model->getErrors();    //得到所有的错误信息
        if (!is_array($errors)) return '';
        $firstError = array_shift($errors);
        if (!is_array($firstError)) return '';
        return array_shift($firstError);
    }

    // 事务中快速报错
    public static function throwError($Res,$msg='')
    {
        if(!$Res){
            throw new \Exception($msg);            
        }
    }

    public static function throwMsg($e)
    {
       return [
           'msg'=>$e->getMessage(),
           'line'=>$e->getLine(),
           'file' => method_exists($e, 'getFile') ? $e->getFile() : '',
           'code'=>$e->getCode(),
           'trace' =>method_exists($e, 'getTrace') ? $e->getTrace() : '',
        ];
    }
}
