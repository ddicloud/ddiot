<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-09 11:20:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-22 22:37:20
 */

namespace common\components\FileUpload;

use Alioss\Core\MimeTypes;
use common\helpers\ArrayHelper;
use common\helpers\FileHelper as HelpersFileHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Exception;
use Faker\Provider\Uuid;
use Local\LocalCor;
use Local\LocalException;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * 文件上传处理.
 */
class Upload extends Model
{
    public $file;
    private $_appendRules;

    public function init()
    {
        parent::init();
        $extensions = Yii::$app->params['webuploader']['baseConfig']['accept']['extensions'];
        $this->_appendRules = [
            [['file'], 'file', 'extensions' => $extensions],
        ];
    }

    public function rules()
    {
        $baseRules = [];
        return array_merge($baseRules, $this->_appendRules);
    }

    public function upImage()
    {
        $model = new static();
        $model->file = UploadedFile::getInstanceByName('file');
        if (!$model->file) {
            return false;
        }
        $relativePath = $successPath = '';
        $fileName = Uuid::uuid() . '.' . $model->file->extension;
        if (!ImageHelper::isImg($fileName)) {
            return ResultHelper::json(400, '请检查图片格式');
        }
        if ($model->validate()) {
            $relativePath = Yii::$app->params['imageUploadRelativePath'];
            $successPath = Yii::$app->params['imageUploadSuccessPath'];
            //$model->file->baseName

            if (!is_dir($relativePath)) {
                HelpersFileHelper::mkdirs($relativePath);
            }
            $Res = $model->file->saveAs($relativePath . $fileName);
            if ($Res) {
                // 云上传
                $Attachment = new OssUpload();
                $cloudOss = $Attachment->file_remote_upload($successPath . $fileName);
                if ($cloudOss['status'] == 200) {
                    $storage = $cloudOss['data']['storage'];
                } else {
                    $storage = 'local';
                }
                ImageHelper::uploadDb($fileName, $model->file->size, $model->file->type, $model->file->extension, $successPath . $fileName, 0, $storage);
            }

            return ResultHelper::json(200, '上传成功', [
                'cloudOss' => $cloudOss,
                'url' => ImageHelper::tomedia($successPath . $fileName),
                'attachment' => $successPath . $fileName,
            ]);
        } else {
            $errors = $model->errors;
            return ResultHelper::json(400, current($errors)[0], $errors);
        }
    }

    /**
     * 文件上传
     * ```
     *  $model = new UploadValidate($config_name);
     *  $result = CommonHelper::myUpload($model, $field, 'invoice');
     * ```.
     *
     * @param object $model \common\models\UploadValidate 验证上传文件
     * @param string $path  文件保存路径
     *
     * @return bool|array
     */
    public static function upFile($model, $path = '', $is_chunk = 0, $chunk_partSize = 5, $chunk_partCount = 0, $chunk_partIndex = 0, $md5 = '', $chunk_md5 = '')
    {
        //文件上传存放的目录
        $upload_path = Yii::getAlias('@frontend/attachment/');
        // 指定存放路径
        $path = $path ? $path . '/' : '';
        $file = UploadedFile::getInstanceByName('file');
        $model->file = $file;
        // 云上传
        $Attachment = new OssUpload();

        if (!empty($is_chunk)) {
            $uploadSuccessPath = ArrayHelper::objectToarray($file);
            // 缓存目录
            $fileName = pathinfo($uploadSuccessPath['tempName']);
            // 目录分割
            $basePath = date('Ym/d') . $path;
            //缓存目录
            $uploadTempDir = str_replace('//', '/', $upload_path . $basePath);
            // 本地上传
            $file = str_replace('//', '/', $uploadTempDir . $fileName['basename']);
            $Res = HelpersFileHelper::file_move($uploadSuccessPath['tempName'], $file);
            if ($Res) {
                return [
                    'status' => 0,
                    'message' => '上传成功',
                    'data' => [
                        // 分片文件路径
                        'file' => $file,
                        // 分片存放目录
                        'temDir' => $uploadTempDir,
                        // 分片大小
                        'chunk_partSize' => (int) $chunk_partSize,
                        // 分片总数
                        'chunk_partCount' => (int) $chunk_partCount,
                        // 分片序号
                        'chunk_partIndex' => (int) $chunk_partIndex,
                        'md5' => $md5,
                        'chunk_md5' => $chunk_md5,
                    ],
                ];
            } else {
                return [
                    'status' => 1,
                    'message' => '上传失败',
                    'data' => [
                        // 分片文件路径
                        'file' => $file,
                        // 分片存放目录
                        'temDir' => $uploadTempDir,
                        // 分片大小
                        'chunk_partSize' => (int) $chunk_partSize,
                        // 分片总数
                        'chunk_partCount' => (int) $chunk_partCount,
                        // 分片序号
                        'chunk_partIndex' => (int) $chunk_partIndex,
                        'md5' => $md5,
                        'chunk_md5' => $chunk_md5,
                    ],
                ];
            }
        }

        $extension = $model->file->extension;

        if ($model->validate()) {
            //生成文件名
            $rand_name = rand(1000, 9999);
            $fileName = $rand_name . '_' . $model->file->baseName . '.' . $model->file->extension;
            $save_dir = $upload_path . $path . date('Ym/d/');
            if (!is_dir($save_dir)) {
                HelpersFileHelper::mkdirs($save_dir);
                chmod($save_dir, 0777);
            }
            $uploadSuccessPath = $path . date('Ym/d/') . $fileName;
            $filePath = $upload_path . $uploadSuccessPath;
            $Res = $model->file->saveAs($filePath);

            if ($Res) {
                $result['name'] = $model->file->baseName . '.' . $model->file->extension;
                $result['extension'] = $model->file->extension;
                $result['attachment'] = $uploadSuccessPath;

                // 云上传
                $cloudOss = $Attachment->file_remote_upload($uploadSuccessPath);

                if ($cloudOss['status'] == 200) {
                    $storage = $cloudOss['data']['storage'];
                } else {
                    $storage = 'local';
                }

                ImageHelper::uploadDb($fileName, $model->file->size, $model->file->type, $model->file->extension, $uploadSuccessPath, 0, $storage);
                $result['cloudOss'] = $cloudOss;

                $result['url'] = ImageHelper::tomedia($uploadSuccessPath);
                $pathinfo = pathinfo($uploadSuccessPath);

                $result['file'] = [
                    'name' => $pathinfo['basename'],
                    'type' => $result['extension'],
                    'size' => (int) $model->file->size,
                    'url' => ImageHelper::tomedia($uploadSuccessPath),
                    'partSize' => (int) $chunk_partSize,
                ];
                return [
                    'status' => 0,
                    'cloudOss' => $cloudOss,
                    'message' => '上传成功',
                    'data' => $result,
                ];
            }
        } else {
            //上传失败记录日志
            $logPath = Yii::getAlias('@runtime/log/upload/' . date('YmdHis') . '.log');
            HelpersFileHelper::writeLog($logPath, Json::encode($model->errors));

            return [
                'status' => 1,
                'file' => $model->file,
                'message' => Json::encode($model->errors),
            ];
        }
    }

    public static function mergeFile($file_name, $file_type, $file_size, $file_parts, $chunk_partSize, $auto_delete_local = true)
    {
        set_time_limit(0);

        // 本地文件做合并处理
        $LocalCor = new LocalCor($file_name, $file_size, $file_type);

        $upload_path = Yii::getAlias('@frontend/attachment/' . date('Ym/d'));

        try {
            $baseFile = $LocalCor->mergeParts($file_parts, $upload_path);
            $storage = 'local';
            $fileInfo = explode('attachment/', $baseFile);

            $file = $fileInfo[1];
            $pathinfo = pathinfo($baseFile);
            $filesize = filesize($baseFile);

            $Attachment = new OssUpload();
            $cloudOss = $Attachment->file_remote_upload_util($baseFile, $chunk_partSize, $auto_delete_local);
            if ($cloudOss['status'] !== 200) {
                throw new \Local\LocalException($cloudOss['message']);
            } else {
                $storage = 'alioss';
            }
            $Mimetype = MimeTypes::getMimetype($baseFile);
            ImageHelper::uploadDb($pathinfo['basename'], $filesize, $Mimetype, $pathinfo['extension'], $file, 0, $storage);
        } catch (\Local\LocalException $e) {
            throw new LocalException($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), '405');
        }

        return [
            'code' => 0,
            'message' => '上传成功',
            'data' => [
                'file' => [
                    'name' => $file_name,
                    'type' => $file_type,
                    'size' => (int) $file_size,
                    'url' => ImageHelper::tomedia($file),
                    'partSize' => (int) $chunk_partSize,
                ],
                'url' => ImageHelper::tomedia($file),
                'attachment' => $file,
                'cloudOss' => $cloudOss,
            ],
        ];
    }
}
