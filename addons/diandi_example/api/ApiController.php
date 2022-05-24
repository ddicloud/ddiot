<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:06:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 13:47:05
 */

namespace addons\diandi_example\api;

use addons\diandi_example\services\MySymfonys\OrderPlacedEvent;
use addons\diandi_example\services\MySymfonys\StoreSubscriber;
use addons\diandi_example\services\ParentEventServer;
use addons\diandi_shop\models\order\DdOrder;
use api\controllers\AController;
use common\components\events\DdDispatcher;
use common\components\events\DdListener;
use common\components\events\eventObjs\DdEvent;
use common\helpers\ResultHelper;
use Yii;

class ApiController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['*'];

    /**
     * @SWG\Post(path="/diandi_shop/address/add",
     *    tags={"收货地址"},
     *    summary="收货地址添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="收货人",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="phone",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="province_id",
     *     type="integer",
     *     description="省份",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="city_id",
     *     type="integer",
     *     description="城市",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="region_id",
     *     type="integer",
     *     description="区县",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="detail",
     *     type="integer",
     *     description="具体地址",
     *     required=true,
     *   )
     * )
     */
    public function actionIndex()
    {
        global $_GPC;

        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id;
        $res = [];

        return ResultHelper::json(200, '请求成功', $res);
    }

    /**
     * 事件处理.
     *
     * @return void
     * @date 2022-05-24
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function actionEvent()
    {
        // 派遣器
        $dispatcher = new DdDispatcher();

        // 监听器
        $listener = new DdListener();

        // 连接到监听器 一次派遣触发一次订阅，尽管订阅的是类，类一个事件包含多个方法，但是也是被派遣和订阅一次触发的
        // $dispatcher->addListener(OrderPlacedEvent::NAME, [$listener, 'onFooAction']);
        $dispatcher->addListener('order.placed', function (DdEvent $event) {
            echo '在order.placed事件被派遣之后执行'.PHP_EOL;
            // print_r($event);
            // will be executed when the foo.action event is dispatched
            // （此处的代码）将在foo.action事件被派遣之后执行
        });

        // 这与监听类很像，除了它自己告诉派遣器“要监听哪些事件”之外。为了把这个订阅器注册给派遣器，使用addSubscriber()方法：
        $subscriber = new StoreSubscriber();
        $Res = $dispatcher->addSubscriber($subscriber);

        // / 订单被以某种方式创建/或者取出
        // $order = new DdOrder();
        $order = DdOrder::find()->asArray()->one();
        // create the OrderPlacedEvent and dispatch it
        // 新建事件并派遣它
        $event = new OrderPlacedEvent($order, 2);
        $dispatcher->dispatch(OrderPlacedEvent::NAME, $event);
        // $event = new ParentEventServer($order,2);
        // 跨模块事件
        $Res = $dispatcher->addListener('foo.method_is_not_found', [$listener, 'onCall']);

        $dispatcher->dispatch(ParentEventServer::EVENT_LOCK_OPEN, $event);

        $event->getOrder();

        return ResultHelper::json(200, '请求成功1', $Res);
    }
}
