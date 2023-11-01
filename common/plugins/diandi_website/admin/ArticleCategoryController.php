<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-21 11:52:14
 */

namespace addons\diandi_website\admin;

use addons\diandi_website\models\searchs\WebsiteArticleCategory as WebsiteArticleCategorySearch;
use addons\diandi_website\models\WebsiteArticleCategory;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ArticleCategoryController implements the CRUD actions for WebsiteArticleCategory model.
 */
class ArticleCategoryController extends AController
{
    public string $modelSearchName = 'WebsiteArticleCategory';

    public $modelClass = '';

    /**
     * Lists all WebsiteArticleCategory models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebsiteArticleCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviders = ArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProviders['allModels'];

        foreach ($parentMent as $key => &$value) {
            $value['label'] = $value['title'];
        }

        $list = ArrayHelper::itemsMerge($parentMent, 0, 'id', 'pcate', 'children');

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebsiteArticleCategory model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new WebsiteArticleCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebsiteArticleCategory();

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
     * Updates an existing WebsiteArticleCategory model.
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
     * Deletes an existing WebsiteArticleCategory model.
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
     * Finds the WebsiteArticleCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsiteArticleCategory the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsiteArticleCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('数据不存在');
    }
}
