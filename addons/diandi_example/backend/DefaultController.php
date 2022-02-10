<?php

namespace addons\diandi_example\backend;


use backend\controllers\BaseController;
use common\services\common\AddonsService;

/**
* Default controller for the `diandi_example` module
*/
class DefaultController extends BaseController
{
/**
* Renders the index view for the module
* @return string
*/
public function actionIndex()
{
    global $_GPC;
        
    $info = AddonsService::getAddonsInfo("diandi_example");
    
    return $this->render('index',[
        'info'=>$info
    ]);
}
}