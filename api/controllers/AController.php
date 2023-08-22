<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-18 06:48:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-27 08:51:08
 */

namespace api\controllers;

use common\components\sign\Sign;
use common\filters\auth\CompositeAuth;
use common\filters\auth\HttpBasicAuth;
use common\filters\auth\HttpBearerAuth;
use common\filters\auth\QueryParamAuth;
use common\helpers\ResultHelper;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Yii;
use yii\base\InlineAction;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * 基类控制器.
 *
 * Class AController
 * @method setResponse($analysisError)
 * @method analysisError($getFirstErrors)
 */
class AController extends ActiveController
{
    /**
     * 不用进行登录验证的方法
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected array $authOptional = [];

    /**
     * 需要进行签名验证的方法 * 全部不需要，all全部需要，update指update需要
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部不需要验证
     *
     * @var array
     */
    protected array $signOptional = ['*'];

    protected array $optionsAction = []; //需要options的方法

    // 主要数据的模型
    public $modelClass = '';

    public function behaviors(): array
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

        // 签名验证
        $behaviors['sign'] = [
            'class' => Sign::className(),
            'key' => Sign::generateSecret(), // 密钥
            'optional' => $this->signOptional,
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
                'Access-Control-Allow-Headers' => ['Content-Type', 'Referer', 'Content-Length', 'Authorization', 'Accept', 'X-Requested-With', 'access-token', 'bloc_id', 'store_id', 'bloc-id', 'store-id'],
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

        return $behaviors;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        Yii::$app->params['bloc_id'] = Yii::$app->service->commonGlobalsService->getBloc_id();
        Yii::$app->params['store_id'] = Yii::$app->service->commonGlobalsService->getStore_id();
        // 集团化参数赋值
        Yii::$app->service->commonGlobalsService->getGlobalBloc();

        return parent::beforeAction($action);
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
            $methodName = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $id))));

            if (method_exists($this, $methodName)) {
                $method = new \ReflectionMethod($this, $methodName);
                if ($method->isPublic() && strtolower($method->getName()) === strtolower($methodName)) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        } else {
            $methodName = 'action' . ucwords($id);
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

        if (empty(Yii::$app->params['bloc_id'])) {
            return ResultHelper::json('400', '缺少公司参数bloc_id');
        }

        if (empty(Yii::$app->params['store_id'])) {
            return ResultHelper::json('400', '缺少门户参数参数store_id');
        }
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
    public function actionIndex(): ActiveDataProvider
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
    public function actionCreate(): bool
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

    // public function checkAccess($action, $model = null, $params = [])
    // {
    //     return false;
    // }
}
