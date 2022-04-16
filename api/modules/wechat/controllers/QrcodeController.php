<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-13 01:02:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-16 16:48:18
 */

namespace api\modules\wechat\controllers;

use api\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * Default controller for the `wechat` module.
 */
class QrcodeController extends AController
{
    public $modelClass = 'api\modules\wechat\models\DdWxappFans';
    // protected $authOptional = ['getqrcode'];

    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionGetqrcode()
    {
        global $_GPC;
        $path = $_GPC['path'];
        $width = $_GPC['width'];

        $module_name = $_GPC['module_name'];
        if (!$module_name) {
            return ResultHelper::json(400, '缺少参数module_name', []);
        }
        $baseInfo = Yii::$app->service->commonMemberService->baseInfo();

        $app = Yii::$app->wechat->miniProgram;

        // 或者指定颜色
        $response = $app->app_code->getUnlimit($baseInfo['member_id'], [
            'page' => $path,
            'width' => $width,
        ]);

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        $directory = Yii::getAlias('@frontend/web/attachment/wxappcode/'.$module_name.'/'.$bloc_id.'/'.$store_id);

        // 或
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filename = $response->saveAs($directory, $baseInfo['fans']['openid'].$baseInfo['member_id'].'.png');
        }

        $codePath = ImageHelper::tomedia('wxappcode/'.$module_name.'/'.$bloc_id.'/'.$store_id.'/'.$baseInfo['fans']['openid'].$baseInfo['member_id'].'.png');

        return ResultHelper::json(200, '获取成功', [
            'codePath' => $codePath,
            'filename' => $filename,
            'fans' => $baseInfo['fans'],
        ]);
    }
}
