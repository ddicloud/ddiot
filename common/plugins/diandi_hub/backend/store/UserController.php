<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-01 14:59:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-26 14:26:44
 */
 

namespace common\plugins\diandi_hub\backend\store;

use Yii;
use common\plugins\diandi_hub\models\store\HubStoreUser;
use common\plugins\diandi_hub\models\Searchs\store\HubStoreUser as HubStoreUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMember;
use diandi\addons\models\BlocStore;

/**
 * UserController implements the CRUD actions for HubStoreUser model.
 */
class UserController extends BaseController
{
    public $modelSearchName = "HubStoreUserSearch
";
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all HubStoreUser models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubStoreUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubStoreUser model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        global $_GPC;
        
        $id = $_GPC['id'];

        return $this->renderView('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubStoreUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubStoreUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubStoreUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubStoreUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    public function actionStorelist()
    {
        global $_GPC;
        
        $keywords = $_GPC['keywords'];
        
        $where = [];
        
        $where1 =[];

        if(!empty($keywords)){
            $where = ['like','name',$keywords];
        }
        
        // $haveStore = HubStoreUser::find()->select(['store_id'])->column();
       
        
        // if(!empty($haveStore)){
        //     $where1 = ['NOT IN','store_id',$haveStore];
        // }

        $list = BlocStore::find()->where($where)->limit(15)->asArray()->all();
        
        foreach ($list as $key => &$value) {
            $value['logo']  = ImageHelper::tomedia($value['logo']);
        }
        
        return ResultHelper::json(200, '获取成功', $list);
        
    }


    public function actionMemberlist()
    {
        global $_GPC;
        
        $keywords = $_GPC['keywords'];
        
        $where = [];
        
        $where1 =[];

        if(!empty($keywords)){
            $where = ['like','username',$keywords];
        }
        
        $haveMember = HubStoreUser::find()->select(['member_id'])->column();
        
        if(!empty($haveMember)){
            $where1 = ['NOT IN','member_id',$haveMember];
        }

        $list = DdMember::find()->where($where)->andFilterWhere($where1)->limit(15)->asArray()->all();
        
        foreach ($list as $key => &$value) {
            $value['logo']  = ImageHelper::tomedia($value['logo']);
        }
        
        return ResultHelper::json(200, '获取成功', $list);
        
    }

    

    
  

    /**
     * Finds the HubStoreUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubStoreUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubStoreUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
