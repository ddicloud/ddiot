<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-25 12:30:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-19 18:02:08
 */
 
namespace console\controllers;

use Yii;

class BaseController extends \yii\console\Controller
{
   
    public $addons;

    public $store_id;
    
    public $bloc_id;
    

    public function actions()
    {
        Yii::$app->service->commonGlobalsService->initId($this->bloc_id, $this->store_id, $this->addons);
        Yii::$app->service->commonGlobalsService->getConf($this->bloc_id);
    }
    
    public function options($actionID)
    {
        return ['addons', 'bloc_id', 'store_id'];
    }
    
    public function optionAliases()
    {
        return [
            'addons' => 'addons',
            'bloc_id' => 'bloc_id',
            'store_id' => 'store_id',
        ];
    }
    
    public function actionIndex($action, $param)
    {
        Yii::$app->getModule($this->addons)->$action($param);
    }
}

?>
