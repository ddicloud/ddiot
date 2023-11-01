<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-19 18:05:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-22 22:38:20
 */


namespace api\controllers;

use Yii;
use common\components\FileUpload\Upload;
use yii\base\ErrorException;
use yii\base\ExitException;
use yii\filters\VerbFilter;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Faker\Provider\Uuid;


class UploadController extends AController
{
    public $modelClass = '';

    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            \Yii::$app->response->setStatusCode(204);
            try {
                \Yii::$app->end();
            } catch (ExitException $e) {
                throw new ErrorException($e->getMessage());
            }
        }
        return $behaviors;
    }

    public function actionImages(): array
    {
        try {
            $model = new Upload();
            $info = $model->upImage();
            return ResultHelper::json(200, '上传成功', $info);
        } catch (\Exception $e) {
            return ResultHelper::json(400, $e->getMessage());
        }
    }

    public function actionBaseimg(): array
    {
        global $_GPC;

        header('Content-type:text/html;charset=utf-8');
        $base64_image_content       =\Yii::$app->request->input('images');


        if (!$base64_image_content) return ['code' => 404, 'msg' => '数据不能为空'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $relativePath = Yii::$app->params['imageUploadRelativePath'];

            $new_file = $relativePath;

            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . Uuid::uuid() . ".$type";
            // base64解码后保存图片
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {

                $file = str_replace('../attachment/', '', $new_file);
                return ['code' => 200, 'message' => '文件保存成功', 'data' => [
                    'attachment' => $file,
                    'url' => ImageHelper::tomedia($file),
                ]];
            } else {
                return ['code' => 4041, 'message' => '文件保存失败', 'data' => null];
            }
        }
        return ['code' => 4041, 'message' => '文件保存失败', 'data' => null];

    }
}
