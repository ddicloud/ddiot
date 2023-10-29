<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:05:00
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\store\HubStoreUser;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\services\MemberService;
use common\plugins\diandi_hub\services\PosterService;
use admin\controllers\AController;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use Yii;

/**
 * Class AddressController.
 */
class MemberController extends AController
{
    public $modelClass = '\common\models\Member';

    public int $searchLevel = 0;

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    // 邀请码注册
    // 分销关系绑定
    // 等级升级
    // 我的二维码
    // 申请提现
    // 成为分销商

    // 获取用户信息

    public function actionInfo()
    {
        global $_GPC;
        $baseInfo = Yii::$app->service->commonMemberService->baseInfo(1);

        $baseInfo['levels'] = MemberService::getByUid($baseInfo['member_id']);
        // 用户基础资产
        $baseInfo['disAccount'] = MemberService::getAccount($baseInfo['member_id']);
        loggingHelper::writeLog('diandi_hub', 'actionInfo', '用户数据', $baseInfo);
        // 是否是首码
        $store_id = Yii::$app->params['global_store_id'];

        $conf = HubConfig::findOne(1);

        if ($conf['onecode'] == $baseInfo['member_id']) {
            $baseInfo['levels']['levelname'] = '总裁';
        }

        $baseInfo['username'] = StringHelper::cut_str($baseInfo['username'], 5);

        // 是否是店员
        $baseInfo['self_store_id'] = HubStoreUser::find()->where(['member_id' => $baseInfo['member_id']])->select(['store_id'])->scalar();

        return ResultHelper::json(200, '获取用户信息成功', $baseInfo);
    }

    public function actionMyagent()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;

        $pageSize = $_GPC['pageSize'];
        $disLevel = $_GPC['disLevel'];
        $keywords = $_GPC['keywords'];
        $page = empty($_GPC['page']) ? 1 : $_GPC['page'];

        $list = levelService::getAllChildDis($member_id, $disLevel, $keywords, $page, $pageSize);
        $totals = levelService::getChildCountByDis($member_id);

        return  ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'count1' => $totals['level1'],
            'count2' => $totals['level2'],
            'total' => $totals['total'],
        ]);
    }

    public function actionQrcode()
    {
        global $_GPC;

        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        $member_id = Yii::$app->user->identity->user_id;

        $baseInfo = Yii::$app->service->commonMemberService->baseInfo(1);

        $scene = $_GPC['scene']; //二维码场景
        $goods_id = $_GPC['goods_id']; //二维码场景

        $url = urldecode(urldecode($_GPC['url'])); //二维码内容

        if (empty($url)) {
            return ResultHelper::json(400, '地址不能为空', []);
        }

        $width = $_GPC['width']; //二维码内容

        if (empty($goods_id)) {
            $img = PosterService::CreateQrcode($url, $scene, $width);
        } else {
            $img = PosterService::CreatePainter($goods_id, $member_id, $url, $scene, $width);
        }

        return ResultHelper::json(200, '生成成功', $img.'?time='.time());
    }

    /**
     * @SWG\Post(path="/diandi_hub/member/wechat-qrcode",
     *    tags={"商品二维码"},
     *    summary="商品二维码详情",
     *    @SWG\Response(response = 200, description = "应用分类详情"),
     *    @SWG\Parameter(in="formData", name="goods_id",type="string", description="商品ID", required=true),
     *    @SWG\Parameter(in="formData", name="scene",type="string", description="同qrcode接口", required=true),
     *    @SWG\Parameter(in="formData", name="url",type="string", description="同qrcode接口", required=true),
     *    @SWG\Parameter(in="formData", name="wechat_path",type="string", description="同创建微信二维码接口参数【path】", required=true),
     *    @SWG\Parameter(in="formData", name="wechat_width",type="string", description="同创建微信二维码接口参数【width】", required=true),
     *    @SWG\Parameter(in="formData", name="wechat_scene",type="string", description="同创建微信二维码接口参数【scene】", required=true),
     * )
     */
    public function actionWechatQrcode()
    {
        global $_GPC;

        $member_id = Yii::$app->user->identity->user_id;
        $scene = $_GPC['scene']; //二维码场景
        $goods_id = $_GPC['goods_id']; //二维码场景
        $url = urldecode(urldecode($_GPC['url'])); //二维码内容
        if (empty($url)) {
            return ResultHelper::json(400, '地址不能为空', []);
        }
        $width = $_GPC['width']; //二维码尺寸

        if (empty($goods_id)) {
            $img = PosterService::CreateQrcode($url, $scene, $width);
        } else {
            $codeImg = $this->_getWechatQrcode();
            $img = PosterService::CreatePainter($goods_id, $member_id, $url, $scene, $width, $codeImg);
        }

        return ResultHelper::json(200, '生成成功', $img.'?time='.time());
    }

    private function _getWechatQrcode()
    {
        global $_GPC;
        $path = $_GPC['wechat_path'];
        $width = $_GPC['wechat_width'];
        $scene = $_GPC['wechat_scene'];
        $module_name = 'diandi_hub';
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
            \common\helpers\FileHelper::mkdirs($directory);
        }
        // 随机文件名称防止重复
        $filename = time().$scene.'.png';
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $Res = $response->saveAs($directory, $filename);
        }
        $codePath = \common\helpers\ImageHelper::tomedia('wxappcode/'.$module_name.'/'.$bloc_id.'/'.$store_id.'/'.$baseInfo['member_id'].'/'.$filename);

        return $codePath;
    }

    public function actionWithdrawlist()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;

        $pageSize = $_GPC['pageSize'];
        $withdraw_status = $_GPC['withdraw_status'];
        $withdraw_type = $_GPC['withdraw_type'];
        $page = empty($_GPC['page']) ? 1 : $_GPC['page'];

        $list = MemberService::Withdrawlist($member_id, $withdraw_status, $withdraw_type, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionEditbankapply()
    {
        $member_id = Yii::$app->user->identity->user_id;

        $Res = MemberService::editbankApply($member_id);

        if ($Res) {
            return ResultHelper::json(200, '申请成功');
        } else {
            return ResultHelper::json(400, '申请失败');
        }
    }

    public function actionAddpayset()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;

        $name = $_GPC['name'];
        if (empty($name)) {
            return ResultHelper::json(400, '真实姓名不能为空');
        }
        $bank_no = $_GPC['bank_no'];
        if (empty($bank_no)) {
            return ResultHelper::json(400, '银行卡号不能为空');
        }
        $mobile = $_GPC['mobile'];
        if (empty($mobile)) {
            return ResultHelper::json(400, '到账通知手机号不能为空');
        }
        $address = $_GPC['address'];
        if (empty($address)) {
            return ResultHelper::json(400, '开户行地址不能为空');
        }
        $province = $_GPC['province'];
        $city = $_GPC['city'];
        $area = $_GPC['area'];
        $thumb = $_GPC['thumb'];
        if (empty($thumb)) {
            return ResultHelper::json(400, '银行卡照片不能为空');
        }
        $card_front = $_GPC['card_front'];
        if (empty($card_front)) {
            return ResultHelper::json(400, '身份证正面不能为空');
        }
        $card_reverse = $_GPC['card_reverse'];
        if (empty($card_reverse)) {
            return ResultHelper::json(400, '身份证反面不能为空');
        }
        // $alipay = $_GPC['alipay'];
        // if (empty($alipay)) {
        //     return ResultHelper::json(400, '支付宝账号不能为空');
        // }
        $alipay = '';

        $Res = MemberService::Addpayset($member_id, $name, $bank_no, $mobile, $address, $province, $city, $area, $thumb, $card_front, $card_reverse, $alipay);

        if ($Res['status'] == 0) {
            return ResultHelper::json(200, '配置成功');
        } else {
            return ResultHelper::json(400, $Res['msg']);
        }
    }

    public function actionGetpayset()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;

        $Res = MemberService::Getpayset($member_id);

        return ResultHelper::json(200, '获取成功', $Res);
    }

    public function actionCollect()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;

        $list = MemberService::Collect($member_id);

        return ResultHelper::json(200, '获取成功', $list);
    }
}
