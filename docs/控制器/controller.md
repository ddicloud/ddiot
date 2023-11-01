# 控制器

### 手机端接口控制器 

+ 继承父类  api\controllers\AController
+ 设置操作的 modelClass
+ 设置不需要签名验证的方法 signOptional 


```
<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 14:00:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 17:52:34
 */

namespace addons\diandi_distribution\api;

use addons\diandi_distribution\models\goods\DistributionGoodsBaseCollect;
use addons\diandi_distribution\services\CartService;
use api\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class CartController.
 */
class CartController extends AController
{
    public $modelClass = '\common\models\DdGoods';

    protected $signOptional = ['Integral'];

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    public function actionAdd()
   {
        $user_id = Yii::$app->user->identity->member_id;

        $goods_id = intval($_GPC['goods_id']);
        $num = intval($_GPC['num']);
        $spec_id = $_GPC['spec_id'];

        $list = CartService::confirm($user_id, $goods_id, $num, $spec_id);

        return ResultHelper::json(200, '加入购物车成功', $list);
    }

    
}

```

### 后台接口控制器 

+ 继承父类  admin\controllers\AController
+ 设置操作的 modelClass
+ 设置检索类名称 modelSearchName （注意：需要与原检索类文件名称相同，不能与as后的名称相同）
+ 设置不需要签名验证的方法 signOptional 

```
<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-10 12:36:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-07 18:48:09
 */

namespace addons\diandi_honorary\admin;

use addons\diandi_honorary\models\HonoraryAar;
use addons\diandi_honorary\models\searchs\HonoraryAar as HonoraryAarSearch;
use admin\controllers\AController;
use common\helpers\DateHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ArrController implements the CRUD actions for HonoraryAar model.
 */
class ArrController extends AController
{
    public $modelSearchName = 'HonoraryAar';

    public $modelClass = '';

    public function actionIndex()
    {
        $searchModel = new HonoraryAarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $time = DateHelper::monthsAgo(3);
        $d = date('d', time());

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'export_time' => [
                date('Y-m-'.$d.' 00:00:00', $time['start']),
                date('Y-m-d 00:00:00', time()),
            ],
        ]);
    }
}

```


### 接口token验证

    控制器私有属性：authOptional

## 默认全部需要验证

```
class ArrController extends AController
{
    protected $authOptional = [];
}
```
## 放行某一个方法,例如index

```
class ArrController extends AController
{
    protected $authOptional = ['index'];

    public function actionIndex()
    {
        $searchModel = new HonoraryAarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $time = DateHelper::monthsAgo(3);
        $d = date('d', time());

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'export_time' => [
                date('Y-m-'.$d.' 00:00:00', $time['start']),
                date('Y-m-d 00:00:00', time()),
            ],
        ]);
    }
}
```

## 放行控制器全部方法

```
class ArrController extends AController
{
    protected $authOptional = ['*'];
}
```


### 接口签名验证

    多用在作为服务提供sdk或接口给其他第三方进行使用 

 控制器私有属性：signOptional

## 默认 `['*']` 全部不需要验证

```
class ArrController extends AController
{
    protected $signOptional = ['*'];
}
```
## 单独某一个方法进行签名,例如index

```
class ArrController extends AController
{
    protected $signOptional = ['index'];

    public function actionIndex()
    {
        $searchModel = new HonoraryAarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $time = DateHelper::monthsAgo(3);
        $d = date('d', time());

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'export_time' => [
                date('Y-m-'.$d.' 00:00:00', $time['start']),
                date('Y-m-d 00:00:00', time()),
            ],
        ]);
    }
}
```

## 控制器全部方法需要进行签名

```
class ArrController extends AController
{
    protected $authOptional = ['all'];
}
```