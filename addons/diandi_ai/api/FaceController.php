<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 19:54:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-23 11:47:35
 */

namespace addons\diandi_ai\api;

use api\controllers\AController;
use addons\diandi_ai\models\DdAiFaces;
use addons\diandi_ai\models\DdAiMember;
use addons\diandi_ai\components\baidu\AipFace;
use addons\diandi_ai\services\BaiduFace;
use Yii;

/**
 * Class FaceController.
 */
class FaceController extends AController
{
    public $modelClass = '\common\models\DdAiMember';
    public $client;

    public function init()
    {
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $this->client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
    }

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    /**
     * 
     * @SWG\Post(path="/diandi_ai/face/detect",
     *     tags={"人脸检测"},
     *     summary="人脸检测接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸检测接口",
     *     ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *   )
     * )
     */
    public function actionDetect()
    {
        global $_GPC;
          
        $Res = BaiduFace::Detect($_GPC['images']);

        return $Res;
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/searchs",
     *     tags={"人脸搜索"},
     *     summary="人脸搜索接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸搜索接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionSearchs()
    {
        global $_GPC;
        $Res  = BaiduFace::Searchs($_GPC['images']);
        return $Res;
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/multiSearch",
     *     tags={"人脸搜索"},
     *     summary="人脸搜索 M:N 识别接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸搜索 M:N 识别接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionMultiSearch()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/addUser",
     *     tags={"人脸库管理"},
     *     summary="人脸注册接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸注册接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionAddUser()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/updateUser",
     *     tags={"人脸识别"},
     *     summary="人脸更新接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸更新接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionUpdateUser()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/faceDelete",
     *     tags={"人脸库管理"},
     *     summary="人脸删除接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸删除接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionFaceDelete()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/getUser",
     *     tags={"人脸库管理"},
     *     summary="用户信息查询接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "用户信息查询接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionGetUser()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/faceGetlist",
     *     tags={"人脸识别"},
     *     summary="获取用户人脸列表接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取用户人脸列表接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionFaceGetlist()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/getGroupUsers",
     *     tags={"人脸识别"},
     *     summary="获取用户列表接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取用户列表接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionGetGroupUsers()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/userCopy",
     *     tags={"人脸库管理"},
     *     summary="复制用户接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "复制用户接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionUserCopy()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/deleteUser",
     *     tags={"人脸识别"},
     *     summary="删除用户接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除用户接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionDeleteUser()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/groupAdd",
     *     tags={"人脸库管理"},
     *     summary="创建用户组接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建用户组接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionGroupAdd()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/groupDelete",
     *     tags={"人脸库管理"},
     *     summary="删除用户组接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除用户组接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionGroupDelete()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/getGroupList",
     *     tags={"人脸库管理"},
     *     summary="组列表查询接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "组列表查询接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionGetGroupList()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/personVerify",
     *     tags={"人脸库管理"},
     *     summary="身份验证接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "身份验证接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionPersonVerify()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/videoSessioncode",
     *     tags={"语音接口"},
     *     summary="语音校验码接口接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "语音校验码接口接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionVideoSessioncode()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/faceverify",
     *     tags={"人脸检测"},
     *     summary="在线活体检测",
     *     @SWG\Response(
     *         response = 200,
     *         description = "在线活体检测"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
      *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionFaceverify()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/match",
     *     tags={"人脸搜索"},
     *     summary="人脸比对",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸比对"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionMatch()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/getVersion",
     *     tags={"人脸识别"},
     *     summary="人脸比对接口",
     *     @SWG\Response(
     *         response = 200,
     *         description = "人脸比对接口"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionGetVersion()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/setConnectionTimeoutInMillis",
     *     tags={"人脸识别"},
     *     summary="脸部识别",
     *     @SWG\Response(
     *         response = 200,
     *         description = "脸部识别base"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionSetConnectionTimeoutInMillis()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/setSocketTimeoutInMillis",
     *     tags={"人脸识别"},
     *     summary="脸部识别",
     *     @SWG\Response(
     *         response = 200,
     *         description = "脸部识别base"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionSetSocketTimeoutInMillis()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/setProxies",
     *     tags={"人脸识别"},
     *     summary="脸部识别",
     *     @SWG\Response(
     *         response = 200,
     *         description = "脸部识别base"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionSetProxies()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/report",
     *     tags={"人脸识别"},
     *     summary="脸部识别",
     *     @SWG\Response(
     *         response = 200,
     *         description = "脸部识别base"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actionReport()
    {
    }

    /**
     * @SWG\Post(path="/diandi_ai/face/Npost",
     *     tags={"人脸识别"},
     *     summary="脸部识别",
     *     @SWG\Response(
     *         response = 200,
     *         description = "脸部识别base"
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="脸部图片路径",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="bloc-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="store-id",
     *      type="integer",
     *      in="header",
     *      required=true
     *   ),
     *   @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *   ),
     * )
     */
    public function actioNpost()
    {
    }
}
