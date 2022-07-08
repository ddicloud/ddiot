<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-18 06:48:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-08 09:12:44
 */

namespace admin\controllers;

use common\filters\auth\CompositeAuth;
use common\filters\auth\HttpBasicAuth;
use common\filters\auth\HttpBearerAuth;
use common\filters\auth\QueryParamAuth;
use common\helpers\loggingHelper;
use diandi\addons\models\DdAddons;
use Yii;
use yii\base\InlineAction;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="dev.hopesfire.com",
 *     basePath="/api/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="店滴云开发手册",
 *     description="店滴云开发手册",
 *     @SWG\Contact(
 *        name="王春生",
 *        email="2192138785@qq.com"
 *     )),
 *     @SWG\Parameter(
 *      in="header",
 *      name="store-id",
 *      type="string",
 *      description="商户ID",
 *      required=true,
 *    ),
 *     @SWG\Parameter(
 *      in="header",
 *      name="bloc-id",
 *      type="string",
 *      description="公司ID",
 *      required=true,
 *    ),
 *     @SWG\Parameter(
 *      in="header",
 *      name="refresh_token",
 *      type="string",
 *      description="刷新token令牌",
 *      required=true,
 *    ),
 *    @SWG\Parameter(
 *      description="用户access-token",
 *      name="access-token",
 *      type="string",
 *      in="header",
 *      required=false
 *   )
 * )
 */
class AController extends ActiveController
{
    private $actionStart = 0;

    private $actionEnd = 0;

    /**
     * 不用进行登录验证的方法
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected $authOptional = [];

    /**
     * 不用进行签名验证的方法
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected $signOptional = [];

    protected $optionsAction = []; //需要options的方法

    // 是否根据公司检索
    public $blocField = 'bloc_id';

    // 是否根据商户检索
    public $storeField = 'store_id';

    public $adminField = 'admin_id';

    // 主要数据的模型
    public $modelClass = '';

    // 主要数据的模型
    public $modelName = '';

    // 检索的模型名称，区分大小写
    public $modelSearchName = '';

    public function behaviors()
    {
        /* 添加行为 */
        $behaviors = parent::behaviors();

        // 速率限制
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
            'errorMessage' => '访问接口太频繁',
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
            // 不进行认证判断方法
            'optional' => $this->authOptional,
        ];

        $urls = Yii::$app->settings->get('Weburl', 'urls');

        // 跨域支持
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => explode(',', $urls),
                // Allow only POST and PUT methods POST, GET, OPTIONS, DELETE
                'Access-Control-Request-Method' => ['POST', 'PUT', 'OPTIONS', 'GET', 'DELETE'],
                'Access-Control-Allow-Headers' => ['Content-Type', 'Referer', 'Content-Length', 'Authorization', 'Accept', 'X-Requested-With', 'access-token', 'bloc-id', 'store-id'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['X-Wsse', 'X-PINGOTHER'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];

        // 添加默认的公司与商户参数
        $behaviors['request'] = [
            'class' => \common\behaviors\HttpRequstMethod::className(),
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        $this->actionStart = microtime(true);
        Yii::$app->params['bloc_id'] = Yii::$app->service->commonGlobalsService->getBloc_id();
        Yii::$app->params['store_id'] = Yii::$app->service->commonGlobalsService->getStore_id();

        loggingHelper::writeLog('adminApi', 'beforeAction', '开始请求', Yii::$app->params['bloc_id']);

        $DdAddons = new DdAddons();

        // 集团化参数赋值
        Yii::$app->service->commonGlobalsService->getGlobalBloc();

        Yii::$app->params['addons'] = Yii::$app->service->commonGlobalsService->getAddons();

        $module = Yii::$app->params['addons'];

        $moduleName = $DdAddons->find()->where(['identifie' => Yii::$app->params['addons']])->asArray()->one();

        Yii::$app->params['moduleAll'] = [];

        $is_addons = $moduleName ? true : false;

        Yii::$app->params['is_addons'] = $is_addons; //  empty($menutypes['type']) ? $nav['top'][0]['mark'] : $menutypes['type'];
        Yii::$app->params['module'] = $moduleName; //  empty($menutypes['type']) ? $nav['top'][0]['mark'] : $menutypes['type'];

        // 初始化权限管理语言包
        if (!isset(Yii::$app->i18n->translations['rbac-admin'])) {
            Yii::$app->i18n->translations['rbac-admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@diandi/admin/messages',
            ];
        }

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        loggingHelper::writeLog('adminApi', 'afterAction', '请求完成');

        $this->actionEnd = microtime(true);

        // 记录API请求接口，耗时took
        loggingHelper::writeLog('adminApi', 'afterAction', '接口请求时间记录', [
            'api' => Yii::$app->request->url,
            'took' => sprintf('%.5f', $this->actionEnd - $this->actionStart),
        ]);

        $afterAction = parent::afterAction($action, $result);

        return $afterAction;
    }

    public function createAction($id)
    {
        if ($id === '') {
            $id = $this->defaultAction;
        }
        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            try {
                return \Yii::createObject($actionMap[$id], [$id, $this]);
            } catch (InvalidConfigException $e) {
            }
        } elseif (preg_match('/^[a-z0-9\\-_]+$/', $id) && strpos($id, '--') === false && trim($id, '-') === $id) {
            $methodName = 'action'.str_replace(' ', '', ucwords(implode(' ', explode('-', $id))));

            if (method_exists($this, $methodName)) {
                $method = new \ReflectionMethod($this, $methodName);
                if ($method->isPublic() && strtolower($method->getName()) === strtolower($methodName)) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        } else {
            $methodName = 'action'.ucwords($id);
            if (method_exists($this, $methodName)) {
                $method = new \ReflectionMethod($this, $methodName);
                if ($method->isPublic() && $method->getName() === $methodName) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        }

        return null;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        // 自定义数据indexDataProvider覆盖IndexAction中的prepareDataProvider()方法
        // $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        //需要在使用的方法加上跨域请求   
        // header('content-type:application/json;charset=utf8');
        // header('Access-Control-Allow-Origin:*');
        // header('Access-Control-Allow-Methods:POST');
        // header('Access-Control-Allow-Headers:x-requested-with,content-type');
        return $actions;
    }

    /**
     * 首页.
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find();

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * 创建.
     *
     * @return bool
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->member_id = Yii::$app->user->identity->user_id;
        $model->attributes = Yii::$app->request->post();

        if (!$model->save()) {
            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        return $model;
    }

    /**
     * 更新.
     *
     * @param $id
     *
     * @return mixed|void
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        return $model;
    }

    /**
     * 删除.
     *
     * @param $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        return $this->findModel($id)->delete();
    }

    /**
     * 详情.
     *
     * @param $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * 返回模型.
     *
     * @param $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (empty($id)) {
            throw new NotFoundHttpException('请求的数据失败.');
        }
        if ($model = $this->modelClass::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('请求的数据失败.');
    }
}
