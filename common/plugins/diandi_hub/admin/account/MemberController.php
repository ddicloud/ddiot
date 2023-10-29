<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-13 03:15:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:15:10
 */
 

namespace common\plugins\diandi_hub\admin\account;

use Yii;
use common\plugins\diandi_hub\models\account\HubMemberAccount;
use common\plugins\diandi_hub\models\Searchs\account\HubMemberAccount as HubMemberAccountSearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * MemberController implements the CRUD actions for HubMemberAccount model.
 */
class MemberController extends AController
{
    public string $modelSearchName = "HubMemberAccount";
    
  

    /**
     * Lists all HubMemberAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HubMemberAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubMemberAccount model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200,'获取成功',[
            'model' => $this->findModel($id),
        ]);
    }

   /**
     * Displays a single HubMemberAccount model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDetail()
    {
        global $_GPC;
        $member_id = $_GPC['member_id']; 
        
        $model = HubMemberAccount::find()->where(['member_id'=>$member_id])->one();
        
        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubMemberAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
 return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the HubMemberAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubMemberAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubMemberAccount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
