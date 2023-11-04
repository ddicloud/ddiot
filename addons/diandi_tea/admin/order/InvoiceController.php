<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-07 16:01:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-30 14:43:23
 */

namespace addons\diandi_tea\admin\order;

use addons\diandi_tea\models\order\TeaInvoice;
use addons\diandi_tea\models\searchs\order\DiandiTeaInvoice;
use admin\controllers\AController;
use api\models\DdMember;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * InvoiceController implements the CRUD actions for TeaInvoice model.
 */
class InvoiceController extends AController
{
    public string $modelSearchName = 'DiandiTeaInvoice';

    public $modelClass = '';

    /**
     * Lists all TeaInvoice models.
     *
     * @return mixed
     */
    public function actionIndex(): array
    {
        $searchModel = new DiandiTeaInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeaInvoice model.
     *
     * @param int $id
     *
     * @return mixed
     *
     */
    public function actionView($id): array
    {
        $view = TeaInvoice::find()->where(['id' => $id])->asArray()->one();
        $view['invoice_url'] = unserialize($view['invoice_url']);
        // $view['invoice_url'] = ImageHelper::tomedia($view['invoice_url']);
        $view['username'] = DdMember::find()->where(['member_id' => $view['member_id']])->asArray()->one()['username'];
        if (is_array($view['invoice_url'])) {
            foreach ($view['invoice_url'] as $key => &$value) {
                $value['size'] = (int) $value['size'];
            }
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new TeaInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new TeaInvoice();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing TeaInvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post();
        $data['invoice_url'] = serialize($data['invoice_url']);

        if ($model->load($data, '') && $model->save()) {
            $model->status = 1;
            $model->save();

            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing TeaInvoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the TeaInvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = TeaInvoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
