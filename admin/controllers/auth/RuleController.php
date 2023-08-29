<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-05-17 15:15:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:46:48
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\admin\components\Configs;
use diandi\admin\components\Helper;
use diandi\admin\models\AuthItem;
use diandi\admin\models\BizRule;
use diandi\admin\models\searchs\BizRule as BizRuleSearch;
use HttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Description of RuleController.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class RuleController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;

   

    /**
     * Lists all AuthItem models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new BizRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return ResultHelper::json(200, '获取成功', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     *
     * @return array
     */
    public function actionView($id): array
    {
        $model = $this->getRule($id);

        return ResultHelper::json(200, '获取成功', ['model' => $model]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new BizRule(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();

            return ResultHelper::json(200, '获取成功',['id' => $model->name]);
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return  ResultHelper::json(500,$msg);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return array
     */
    public function actionUpdate($id): array
    {
        $model = $this->getRule($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();

            return ResultHelper::json(200, '获取成功',['view', 'id' => $model->name]);
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return  ResultHelper::json(500,$msg);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return array
     */
    public function actionDelete($id): array
    {
        $model = $this->getRule($id);
        Configs::authManager()->remove($model->item);
        Helper::invalidate();
        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return AuthItem|BizRule|array the loaded model
     */
    protected function getRule(string $id): AuthItem|BizRule|array
    {
        $item = Configs::authManager()->getRule($id);
        if ($item) {
            return new BizRule($item);
        } else {
            return ResultHelper::json(500, '请检查数据是否存在');
        }
    }
}
