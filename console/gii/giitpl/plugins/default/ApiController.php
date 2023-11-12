<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-10 02:18:01
 */
echo "<?php\n";
?>
namespace <?= $generator->getControllerNamespace().'\\api'; ?>;

use Yii;
use api\controllers\AController;
use common\helpers\ResultHelper;


class ApiController extends AController
{
    public $modelClass = '';

  

    public function actionIndex(): array
   {

        $data = Yii::$app->request->input();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id;
        $res = [];

        return ResultHelper::json(200, '请求成功', $res);
    }

}
