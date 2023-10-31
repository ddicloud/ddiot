<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-26 03:34:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:04:36
 */

namespace common\plugins\diandi_hub\admin\member;

use common\plugins\diandi_hub\models\member\HubUserBank;
use common\plugins\diandi_hub\models\Searchs\member\HubUserBank as HubUserBankSearch;
use admin\controllers\AController;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * BankController implements the CRUD actions for HubUserBank model.
 */
class BankController extends AController
{
    public string $modelSearchName = 'HubUserBankSearch
';

    /**
     * Lists all HubUserBank models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubUserBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubUserBank model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200,'获取成功',[
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubUserBank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubUserBank();

          if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
      return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubUserBank model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $member_id = $_GPC['member_id'];

        $member = HubUserBank::find()->where(['member_id' => $member_id])->one();
        if (empty($member)) {
            Yii::$app->session->setFlash('error', '用户未设置收款账号,请关闭窗口');

            return $this->redirect(['index']);
        }
        $model = $this->findModel($member['id']);
          if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
      return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubUserBank model.
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
 return ResultHelper::json(200,'删除成功');
    }

    public function actionExportdatalist()
    {
        global $_GPC;

        $list = HubUserBank::find()->all();

        if (!empty($list)) {
            $fileName = '收款账户'.date('Y-m-d H:i:s', time()).'.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/back/'.date('Y/m/d/', time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $list,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath' => $savePath,
            ]);

            return ResultHelper::json(200, '下载成功', [
                'url' => ImageHelper::tomedia('/diandi_hub/excel/back/'.date('Y/m/d/', time()).$fileName),
            ]);
        } else {
            return ResultHelper::json(400, '没有可以下载的数据');
        }
    }

    /**
     * Finds the HubUserBank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubUserBank the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubUserBank::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
