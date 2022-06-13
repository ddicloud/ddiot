<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-05-17 15:15:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 17:19:11
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use Yii;

/**
 * DefaultController.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class DefaultController extends AController
{
    public $modelClass = '';

    /**
     * Action index.
     */
    public function actionIndex($page = 'README.md')
    {
        if (strpos($page, '.png') !== false) {
            $file = Yii::getAlias("@diandi/admin/{$page}");

            return Yii::$app->getResponse()->sendFile($file);
        }

        return $this->render('index', ['page' => $page]);
    }
}
