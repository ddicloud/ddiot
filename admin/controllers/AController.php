<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-18 06:48:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 15:38:39
 */

namespace admin\controllers;

use common\behaviors\HttpRequstMethod;
use common\filters\auth\CompositeAuth;
use common\filters\auth\HttpBasicAuth;
use common\filters\auth\HttpBearerAuth;
use common\filters\auth\QueryParamAuth;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\middlewares\AccessControl;
use diandi\addons\models\DdAddons;
use Yii;
use yii\base\InlineAction;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AController extends ActiveController
{
    private float|string $actionStart = 0;

    /**
     * 不用进行登录验证的方法
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected array $authOptional = [];

    /**
     * 不用进行签名验证的方法
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected array $signOptional = [];


    /**
     * 数据分离等级. 0不检索商户与公司，1只检索公司，2检索公司和商户.
     *
     * @var int
     * @date 2022-10-28
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public int $searchLevel = 2;

    // 根据公司检索字段,不参与检索设置为false
    public string $blocField = 'bloc_id';

    // 根据商户检索字段,不参与检索设置为false
    public string $storeField = 'store_id';

    // 根据商户检索字段,不参与检索设置为false
    public string $adminField = 'admin_id';

    // 主要数据的模型
    public $modelClass = '';

    // 检索的模型名称，区分大小写，注意是原来的类名称，不能是as后的，
    public string $modelSearchName = '';

    public function behaviors(): array
    {
        /* 添加行为 */
        $behaviors = parent::behaviors();

        // 速率限制
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::class,
            'enableRateLimitHeaders' => true,
            'errorMessage' => '访问接口太频繁',
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
            // 不进行认证判断方法
            'optional' => $this->authOptional,
        ];

        $urls = Yii::$app->settings->get('Weburl', 'urls');

        // 跨域支持
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
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
            'class' => HttpRequstMethod::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'allowActions' => [
                'user/login', //登录
                'user/signup', //注册
                'user/repassword', //修改密码
                'user/sendcode', //发送验证码
                'user/forgetpass', //方剂密码
                'user/refresh', //刷新token
                'user/userinfo', //用户信息
                'map/citylist', //城市数据
                'addons/bloc/*', //公司管理
                'addons/store/*', //商户管理
                'addons/category/*', //商户分类
                'addons/storelabel/*',
                'addons/bloclevel/*', //公司等级数据
                'addons/addons/*', //业务
                'system/config/*', //系统配置
                'member/dd-member/*', //会员
                'member/organization/*', //组织机构
                'website/setting/info', //系统默认信息
                'system/index/menus', //系统菜单
                'system/welcome/index',
                'system/index/info',
                'system/settings/set-cache',
                'system/settings/store',
                'system/settings/ueditor', //百度编辑器配置信息
                'file/upload/*', //上传资源
            ],
        ];

        return $behaviors;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $this->actionStart = microtime(true);
        Yii::$app->params['bloc_id'] = Yii::$app->service->commonGlobalsService->getBloc_id();
        Yii::$app->params['store_id'] = Yii::$app->service->commonGlobalsService->getStore_id();

        loggingHelper::writeLog('adminApi', 'beforeAction', '开始请求', Yii::$app->params['bloc_id']);

        $DdAddons = new DdAddons();

        // 集团化参数赋值
        Yii::$app->service->commonGlobalsService->getGlobalBloc();

        Yii::$app->params['addons'] = Yii::$app->service->commonGlobalsService->getAddons();


        $moduleName = $DdAddons->find()->where(['identifie' => Yii::$app->params['addons']])->asArray()->one();

        Yii::$app->params['moduleAll'] = [];

        $is_addons = (bool)$moduleName;

        Yii::$app->params['is_addons'] = $is_addons;
        Yii::$app->params['module'] = $moduleName;

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

        $actionEnd = microtime(true);

        // 记录API请求接口，耗时took
        loggingHelper::writeLog('adminApi', 'afterAction', '接口请求时间记录', [
            'api' => Yii::$app->request->url,
            'took' => sprintf('%.5f', $actionEnd - $this->actionStart),
        ]);

        return parent::afterAction($action, $result);
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function createAction($id): ?object
    {
        if ($id === '') {
            $id = $this->defaultAction;
        }
        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            try {
                return Yii::createObject($actionMap[$id], [$id, $this]);
            } catch (InvalidConfigException $e) {
                throw new UnauthorizedHttpException($e->getMessage(),500);
            }
        } elseif (preg_match('/^[a-z0-9\\-_]+$/', $id) && !str_contains($id, '--') && trim($id, '-') === $id) {
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

    public function actions(): array
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    /**
     * 首页.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        $list = new ActiveDataProvider([
            'query' => $query,
        ]);
        return ResultHelper::json(200,'获取成功', (array)$list);
    }

    /**
     * 创建.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new $this->modelClass();
        $model->member_id = Yii::$app->user->identity->user_id??0;
        $model->attributes = Yii::$app->request->post();

        if (!$model->save()) {
            // 返回数据验证失败
            $msg = $model->getFirstErrors();
            return ResultHelper::json(500,$msg);

        }
        return ResultHelper::json(200,'创建成功', (array)$model);
    }

    /**
     * 更新.
     *
     * @param $id
     *
     * @return array
     *
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            // 返回数据验证失败

            $msg = $model->getFirstErrors();
            return ResultHelper::json(500,$msg);

        }

        return ResultHelper::json(200,'创建成功', (array)$model);

    }

    /**
     * 删除.
     *
     * @param $id
     *
     * @return array
     *
     */
    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException $e) {
            return ResultHelper::json(500,$e->getMessage());
        } catch (\Throwable $e) {
            return ResultHelper::json(500,$e->getMessage());
        }
        return ResultHelper::json(200,'删除成功');

    }

    /**
     * 详情.
     *
     * @param $id
     *
     * @return array
     *
     */
    public function actionView($id): array
    {
        $detail = $this->findModel($id);
        return ResultHelper::json(200,'获取成功',$detail);

    }

    /**
     * 返回模型.
     *
     * @param $id
     *
     * @return array|ActiveRecord
     *
     */
    protected function findModel($id): array|ActiveRecord
    {
        if (empty($id)) {
            return ResultHelper::json(500,'id不能为空');
        }
        if ($model = $this->modelClass::findOne($id)) {
            return $model;
        }else{
            return [];
        }
    }
}
