<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:45:44
 */

namespace admin\controllers\system;

use admin\controllers\AController;
use admin\services\UserService;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\web\Response;

class IndexController extends AController
{
    public $modelClass = ' ';

    public $enableCsrfValidation = false;

    public $searchLevel = 0;

    // public $layout = false;

    public function actionIndex()
    {
        $csrfToken = Yii::$app->request->csrfToken;

        return ResultHelper::json(200, '获取成功', ['csrfToken' => $csrfToken]);
    }

    /**
     * @return string
     */
    public function actionChildcate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $pid = Yii::$app->request->post('parent_id');
            $cates = DdRegion::findAll(['pid' => $pid]);

            return $cates;
        }
    }

    public function actionMenus()
    {
        global $_GPC;

        $list = UserService::getUserMenus();

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function creAteVue($menus)
    {
        foreach ($menus as $key => $value) {
            if ($value['component'] != 'Layout') {
                $path = $value['component'];
                $mark = $value['name'];
                $content = "<template>
                <div>
                {$mark} 
                </div>
                </template>
                
                <script>
                export default {
                    name: '',
                    components: {  },
                    data() {
                      return {
                       
                      }
                    }
                  }
                </script>
                
                <style lang=\\\"scss \\\" scoped>
                </style>
                ";
                self::writeLog($path, $mark, $content);
            } else {
                if (!empty($value['children'])) {
                    $this->creAteVue($value['children']);
                }
            }
        }
    }

    /**
     * 写入日志.
     *
     * @param $path
     * @param $content
     *
     * @return bool|int
     */
    public static function writeLog($path, $mark, $content)
    {
        $appId = Yii::$app->id;

        $basepath = Yii::getAlias('@admin/vue/'.$path.'.vue');
        loggingHelper::mkdirs(dirname($basepath));
        @chmod($path, 0777);
        $time = date('m/d H:i:s');

        return file_put_contents($basepath, $content, FILE_APPEND);
    }
}
