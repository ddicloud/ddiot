<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 15:01:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-04 19:41:31
 */
 

namespace backend\controllers\member;

use api\models\DdMember as ModelsDdMember;
use Yii;
use common\models\DdMember;
use common\models\searchs\DdMemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdMemberGroup;
use common\models\forms\PasswdForm;

/**
 * DdMemberController implements the CRUD actions for DdMember model.
 */
class DdMemberController extends BaseController
{
    public $modelSearchName = "DdMemberSearch";
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all DdMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        global $_GPC;
        $searchModel = new DdMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->renderView('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdMember model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderView('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DdMember();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->member_id]);
        }
        
        $group = DdMemberGroup::find()->asArray()->all();
        
        return $this->renderView('create', [
                'group' => $group,
                'model' => $model,
        ]);
    }

    /**
     * Updates an existing DdMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->member_id]);
        }

        $group = DdMemberGroup::find()->asArray()->all();

        return $this->renderView('update', [
                'group' => $group,
                'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DdMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        global $_GPC;

        if(Yii::$app->request->isPost){
            
            $ids = explode(',',$_GPC['ids']);
            $model = new DdMember();
            $where = ['in', 'member_id', $ids];
            $model->deleteAll($where);
            
            return ResultHelper::json(200,'删除成功',[]);    
        
        }else{
            
            return ResultHelper::json(400,'非ajax操作不能删除',[]);    
            
        }
        
    }

    
    public function actionGroups()
    {
        $list = DdMemberGroup::find()->asArray()->all();
        
        return ResultHelper::json(200,'获取成功',$list);    
    }

    public function actionRepassword()
    {
        $model = new PasswdForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                $res = ErrorsHelper::getModelError($model);
                return ResultHelper::json(404, $res);
            }
            /* @var $member \common\models\backend\Member */
            $data = Yii::$app->request->post();
            $mobile = $data['mobile'];
           

            $member = ModelsDdMember::findByMobile($data['mobile']);
            $member->password_hash = Yii::$app->security->generatePasswordHash($model->newpassword);
            $member->generatePasswordResetToken();
            if ($member->save()) {
              
                return ResultHelper::json(200, '修改成功');
            }else{
                $res = ErrorsHelper::getModelError($member);
                return ResultHelper::json(401, $res);
            }
            
        } else {
            $res = ErrorsHelper::getModelError($model);
            return ResultHelper::json(401, $res);
        }
    }

    /**
     * Finds the DdMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DdMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DdMember::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
