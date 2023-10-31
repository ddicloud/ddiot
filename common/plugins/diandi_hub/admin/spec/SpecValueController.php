<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-14 09:10:25
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-13 14:43:23
 */

namespace common\plugins\diandi_hub\admin\spec;

use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\models\goods\HubSpecValue;
use common\plugins\diandi_hub\models\Searchs\goods\HubSpecValueSearchs;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * SpecValueController implements the CRUD actions for HubSpecValue model.
 */
class SpecValueController extends AController
{
    public string $modelSearchName = 'HubSpecValueSearchs';

    public $modelClass = '';

    /**
     * Lists all HubSpecValue models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubSpecValueSearchs();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubSpecValue model.
     *
     * @param int $id
     *
     * @return array
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

        $arr = explode(',', $view->category_ids);
        $a = [];
        if (is_array($arr)) {
            foreach ($arr as $key => &$value) {
                $value = (int) $value;
                if ($temp = HubCategory::find()->where(['category_id' => $value])->select('parent_id')->scalar()) {
                    $a[$key][] = $temp;
                }
                $a[$key][] = $value;
            }
        }
        $view->category_ids = $a;

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new HubSpecValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubSpecValue();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $arr = [];
            if (is_array($data['category_ids'])) {
                foreach ($data['category_ids'] as $key => $value) {
                    if ($value[1]) {
                        $arr[] = $value[1];
                    }
                }
                $arr = array_unique($arr);
                $data['category_ids'] = implode(',', $arr);
            }
            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '创建成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing HubSpecValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();
            $arr = [];
            if (is_array($data['category_ids'])) {
                foreach ($data['category_ids'] as $key => $value) {
                    if ($value[1]) {
                        $arr[] = $value[1];
                    }
                }
                $arr = array_unique($arr);
                $data['category_ids'] = implode(',', $arr);
            }

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing HubSpecValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the HubSpecValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubSpecValue the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubSpecValue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
