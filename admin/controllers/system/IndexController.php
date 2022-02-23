<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-23 12:45:44
 */





namespace admin\controllers\system;

use admin\controllers\AController;
use admin\models\auth\AuthRoute;
use Yii;
use  backend\controllers\BaseController;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use admin\models\forms\LoginForm;
use diandi\addons\models\AddonsUser;
use diandi\admin\models\Menu;
use diandi\admin\models\UserGroup;
use yii\web\Response;

/**
 *
 */
class IndexController extends AController
{

    public $modelClass = ' ';

    public $enableCsrfValidation = false;
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

        // 初始化菜单
        $is_addons = Yii::$app->params['is_addons'];

        $AllNav   = Yii::$app->service->adminNavService->getMenu('', $is_addons);
        $leftMenu = $AllNav['left'];

        $AddonsUser = new AddonsUser();
        $module_names = $AddonsUser->find()->where([
            'user_id' =>  Yii::$app->user->identity->user_id,
        ])->with(['addons'])->asArray()->all();

        foreach ($module_names as $key => &$value) {
            if (empty($value['addons'])) {
                unset($module_names[$key]);
            }
        }

        $moduleAll =  $module_names ? $module_names : [];

        $Website   = Yii::$app->settings->getAllBySection('Website');
        $Website['blogo']   = ImageHelper::tomedia($Website['blogo']);
        $Website['flogo']   = ImageHelper::tomedia($Website['flogo']);

        $Website['themcolor']   = !empty(Yii::$app->cache->get('themcolor')) ? Yii::$app->cache->get('themcolor') : $Website['themcolor'];


        $Roles = UserGroup::find()->select('name')->column();

        return ResultHelper::json(200, '获取成功', [
            'left' => $AllNav['left'],
            'top' => $AllNav['top'],
            'Roles' => $Roles,
            'moduleAll' => $moduleAll,
        ]);
    }

    public function creAteVue($menus)
    {
        foreach ($menus as $key => $value) {
            if ($value['component'] != 'Layout') {
                $path  = $value['component'];
                $mark  = $value['name'];
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
     * 写入日志
     *
     * @param $path
     * @param $content
     * @return bool|int
     */
    public static function writeLog($path, $mark, $content)
    {
        $appId = Yii::$app->id;

        $basepath = Yii::getAlias("@admin/vue/" . $path . '.vue');
        loggingHelper::mkdirs(dirname($basepath));
        @chmod($path, 0777);
        $time = date('m/d H:i:s');
        return file_put_contents($basepath, $content, FILE_APPEND);
    }
}
