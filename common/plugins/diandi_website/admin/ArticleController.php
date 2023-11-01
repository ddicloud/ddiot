<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 17:49:31
 */

namespace addons\diandi_website\admin;

use addons\diandi_website\models\searchs\WebsiteArticle as WebsiteArticleSearch;
use addons\diandi_website\models\searchs\WebsiteArticleCategory;
use addons\diandi_website\models\WebsiteArticle;
use addons\diandi_website\models\WebsitePageConfig;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ArticleController implements the CRUD actions for WebsiteArticle model.
 */
class ArticleController extends AController
{
    public string $modelSearchName = 'WebsiteArticle';

    public $modelClass = '';

    /**
     * Lists all WebsiteArticle models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebsiteArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebsiteArticle model.
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

    public function actionCate()
   {
        $where['store_id'] =\Yii::$app->request->input('store_id',0);
        $where['bloc_id'] =\Yii::$app->request->input('bloc_id',0);
        $where['pcate'] =\Yii::$app->request->input('pcate');

        $model = new WebsiteArticleCategory();
        $list = $model->find()->where($where)->select(['id', 'title as label'])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * @SWG\Post(path="/diandi_website/article/create",
     *    tags={"文章 - 202206"},
     *    summary="添加 - 新增字段（遗弃）",
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加",
     *     ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="is_top",
     *     type="integer",
     *     description="是否置顶（-1：否，1：是）",
     *     required=true,
     *   )
     * )
     */
    public function actionCreate()
    {
        $model = new WebsiteArticle();

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
     * @SWG\Post(path="/diandi_website/article/update/{id}",
     *    tags={"文章 - 202206"},
     *    summary="编辑 - 新增字段（遗弃）",
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加",
     *     ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="is_top",
     *     type="integer",
     *     description="是否置顶（-1：否，1：是）",
     *     required=true,
     *   )
     * )
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
     * Deletes an existing WebsiteArticle model.
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
     * Finds the WebsiteArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsiteArticle the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsiteArticle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPageList()
   {
        $where['store_id'] =\Yii::$app->request->input('store_id',0);
        $where['bloc_id'] =\Yii::$app->request->input('bloc_id',0);

        $detail = WebsitePageConfig::find()->select(['title AS label', 'id'])
            ->where($where)->asArray()->all();

        return ResultHelper::json(200, '请求成功', $detail);
    }
}
