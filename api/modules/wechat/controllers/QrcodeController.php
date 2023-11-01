<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-13 01:02:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-20 18:56:04
 */

namespace api\modules\wechat\controllers;

use api\controllers\AController;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\RuntimeException;
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
     * @return array|object[]|string|string[]
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function actionGetqrcode(): array|string
   {
        $path =\Yii::$app->request->input('path');
        $width =\Yii::$app->request->input('width');
        $scene =\Yii::$app->request->input('scene');

        $module_name =\Yii::$app->request->input('module_name');
        if (!$module_name) {
            return ResultHelper::json(400, '缺少参数module_name');
        }
        $baseInfo = Yii::$app->service->commonMemberService->baseInfo();

        $app = Yii::$app->wechat->miniProgram;

        // 或者指定颜色
        $response = $app->app_code->getUnlimit($scene, [
            'page' => $path,
            'width' => $width,
        ]);

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        $directory = Yii::getAlias('@frontend/attachment/wxappcode/'.$module_name.'/'.$bloc_id.'/'.$store_id.'/'.$baseInfo['member_id']);

        if (!is_dir($directory)) {
            FileHelper::mkdirs($directory);
        }

        // 随机文件名称防止重复
        $filename = time().md5($scene).'.png';

        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $Res = $response->saveAs($directory, $filename);
            if(!$Res){
                return ResultHelper::json(400, '获取失败',$Res);
            }
            $codePath = ImageHelper::tomedia('wxappcode/'.$module_name.'/'.$bloc_id.'/'.$store_id.'/'.$baseInfo['member_id'].'/'.$filename);

            return ResultHelper::json(200, '获取成功', [
                'codePath' => $codePath,
                'response' => $response,
                'filename' => $filename,
                'fans' => $baseInfo['fans'],
            ]);
        }


    }
}
