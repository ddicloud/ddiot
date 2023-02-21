<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-09 11:19:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-02-21 13:27:26
 */

namespace admin\controllers\file;

use admin\controllers\AController;
use common\components\FileUpload\models\UploadValidate;
use common\components\FileUpload\Upload;
use common\helpers\ResultHelper;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class UploadController extends AController
{
    public $modelClass = '';

    public $enableCsrfValidation = false;

    public $searchLevel = 0;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            \Yii::$app->response->setStatusCode(204);
            \Yii::$app->end(0);
        }

        return $behaviors;
    }

    /**
     * @SWG\Post(path="/file/images",
     *     tags={"资源上传"},
     *     summary="上传图片",
     *     @SWG\Response(
     *         response = 200,
     *         description = "上传图片",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="需要上传的图片",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     )
     * )
     */
    public function actionImages()
    {
        global $_GPC;
        try {
            $model = new Upload();
            $info = $model->upImage();
            $info && is_array($info) ?
                exit(Json::htmlEncode($info)) :
                exit(Json::htmlEncode([
                    'code' => 1,
                    'msg' => 'error',
                ]));
        } catch (\Exception $e) {
            exit(Json::htmlEncode([
                'code' => 1,
                'msg' => $e->getMessage(),
            ]));
        }
    }

    /**
     * @SWG\Post(path="/file/file",
     *     tags={"资源上传"},
     *     summary="上传文件",
     *     @SWG\Response(
     *         response = 200,
     *         description = "上传文件",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="需要上传的文件",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     )
     * )
     */
    public function actionFile()
    {
        global $_GPC;

        try {
            $Upload = new Upload();
            //实例化上传验证类，传入上传配置参数项名称
            $model = new UploadValidate('uploadFile');
            $field = $_GPC['field'];
            $path = $_GPC['path'];
            $is_chunk = $_GPC['is_chunk'];
            $chunk_partSize = $_GPC['chunk_partSize'];
            $chunk_partCount = $_GPC['chunk_partCount'];
            $chunk_partIndex = $_GPC['chunk_partIndex'];
            $md5 = $_GPC['md5'];
            $chunk_md5 = $_GPC['chunk_md5'];

            if (!empty($is_chunk)) {
                if (!$chunk_partSize) {
                    return  ResultHelper::json(400, '必须指明分片尺寸：chunk_partSize');
                }

                if (!$chunk_partCount) {
                    return  ResultHelper::json(400, '必须指明分片总数：chunk_partCount');
                }
            }

            //上传
            $info = $Upload::upFile($model, urldecode($path), $is_chunk, $chunk_partSize, $chunk_partCount, $chunk_partIndex, $md5, $chunk_md5);

            if ($info['status'] == 0) {
                return ResultHelper::json(200, $info['message'], $info['data']);
            } else {
                return ResultHelper::json(400, $info['message'], $info['data']);
            }
        } catch (\Exception $e) {
            return  ResultHelper::json(400, $e->getMessage(), $e);
        }
    }

    /**
     * @SWG\Post(path="/file/merge",
     *     tags={"资源上传"},
     *     summary="本地文件合并",
     *     @SWG\Response(
     *         response = 200,
     *         description = "上传文件",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="images",
     *      type="string",
     *      description="需要上传的文件",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     )
     * )
     */
    public function actionMerge()
    {
        global $_GPC;
        try {
            $Upload = new Upload();
            //实例化上传验证类，传入上传配置参数项名称
            $model = new UploadValidate('uploadFile');
            $file_name = $_GPC['file_name'];
            $file_type = $_GPC['file_type'];
            $file_size = $_GPC['file_size'];
            $file_parts = $_GPC['file_parts'];
            $chunk_partSize = $_GPC['chunk_partSize'];
            //合并且进行云分片处理
            $info = $Upload::mergeFile($file_name, $file_type, $file_size, $file_parts, $chunk_partSize);

            if ($info['code'] == 0) {
                return ResultHelper::json(200, $info['message'], $info['data']);
            } else {
                $msg = json_decode($info['msg'], true);

                return ResultHelper::json(400, $msg['file'][0]);
            }
        } catch (\Exception $e) {
            exit(Json::htmlEncode([
                'code' => 1,
                'msg' => $e->getMessage(),
            ]));
        }
    }
}
