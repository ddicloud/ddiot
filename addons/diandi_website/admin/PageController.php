<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-20 16:59:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-06 18:16:20
 */

namespace addons\diandi_website\admin;

use addons\diandi_website\models\searchs\WebsitePage as WebsitePageSearch;
use addons\diandi_website\models\WebsitePage;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for WebsitePage model.
 */
class PageController extends AController
{
    public string $modelSearchName = 'WebsitePageSearch';

    public $modelClass = '';

    /**
     * Lists all WebsitePage models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebsitePageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebsitePage model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new WebsitePage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebsitePage();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '创建成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing WebsitePage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing WebsitePage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the WebsitePage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsitePage the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsitePage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
