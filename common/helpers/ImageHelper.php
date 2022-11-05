<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-01 15:32:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-05 18:39:06
 */

namespace common\helpers;

use common\components\FileUpload\models\DdUploadFileUsed;
use common\components\FileUpload\models\UploadFile;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class ImageHelper.
 *
 * @author chunchun <2192138785@qq.com>
 */
class ImageHelper
{
    /**
     * 默认图片.
     *
     * @param $imgSrc
     * @param string $defaultImgSre
     *
     * @return string
     */
    function default($imgSrc, $defaultImgSre = '/resources/img/error.png') {
        return !empty($imgSrc) ? $imgSrc : Yii::getAlias('@web') . $defaultImgSre;
    }

    /**
     * 默认头像.
     *
     * @param $imgSrc
     */
    public static function defaultHeaderPortrait($imgSrc, $defaultImgSre = '/resources/img/profile_small.jpg')
    {
        return !empty($imgSrc) ? $imgSrc : Yii::getAlias('@web') . $defaultImgSre;
    }

    /**
     * 点击大图.
     *
     * @param string $imgSrc
     * @param int    $width  宽度 默认45px
     * @param int    $height 高度 默认45px
     */
    public static function fancyBox($imgSrc, $width = 45, $height = 45)
    {
        $image = Html::img($imgSrc, [
            'width' => $width,
            'height' => $height,
        ]);

        return Html::a($image, $imgSrc, [
            'data-fancybox' => 'gallery',
        ]);
    }

    /**
     * 显示图片列表.
     *
     * @param $covers
     *
     * @return string
     */
    public static function fancyBoxs($covers, $width = 45, $height = 45)
    {
        $image = '';
        if (empty($covers)) {
            return $image;
        }

        !is_array($covers) && $covers = Json::decode($covers);

        foreach ($covers as $cover) {
            $image .= Html::tag('span', self::fancyBox($cover, $width, $height), [
                'style' => 'padding-right:5px;padding-bottom:5px',
            ]);
        }

        return $image;
    }

    /**
     * 判断是否图片地址
     *
     * @param string $imgSrc
     *
     * @return bool
     */
    public static function isImg($imgSrc)
    {
        $extend = StringHelper::clipping($imgSrc, '.', 1);

        $imgExtends = [
            'bmp',
            'jpg',
            'gif',
            'jpeg',
            'jpe',
            'jpg',
            'png',
            'jif',
            'dib',
            'rle',
            'emf',
            'pcx',
            'dcx',
            'pic',
            'tga',
            'tif',
            'tiffxif',
            'wmf',
            'jfif',
        ];
        if (in_array($extend, $imgExtends) || strpos($imgSrc, 'http://wx.qlogo.cn') !== false) {
            return true;
        }

        return false;
    }

    public static function getMediaUrl($image)
    {
        $url = '';
        // 根据上传记录判断上传类型
        $storage = UploadFile::find()->where(['file_url' => $image])->select('storage')->scalar();
        $appId = Yii::$app->id;

        switch ($appId) {
            case 'app-swoole':
                $hostInfo = '';
                break;
            case 'app-console':
                $hostInfo = '';
                break;
            default:
                $hostInfo = Yii::$app->request->hostInfo || '';
                break;
        }

        switch ($storage) {
            case 'locai':
                $url = $hostInfo;
                break;
            case 'alioss':
                $url = Yii::$app->params['conf']['oss']['Aliyunoss_url'];
                break;
            case 'qiniu':
                $url = Yii::$app->params['conf']['oss']['Qiniuoss_url'];
                break;
            case 'cos':
                $url = Yii::$app->params['conf']['oss']['Tengxunoss_url'];
                break;
            default:
                $url = $hostInfo;
                break;
        }

        return $url ? $url : $hostInfo;
    }

    public static function tomedia($image, $type = 'default.jpg')
    {
        $hostUrl = self::getMediaUrl($image);
        $default = '/resource/images/public/' . $type;
        if (is_array($image)) {
            foreach ($image as $key => &$value) {
                if ('//' == substr($value, 0, 2)) {
                    $value = 'http:' . $value;
                } elseif (('http://' == substr($value, 0, 7)) || ('https://' == substr($value, 0, 8))) {
                    $value = $value;
                } else {
                    $value = $value ? $hostUrl . '/attachment/' . $value : $hostUrl . $default;
                }
            }
        } else {
            if ('//' == substr($image, 0, 2)) {
                return 'http:' . $image;
            }
            if (('http://' == substr($image, 0, 7)) || ('https://' == substr($image, 0, 8))) {
                return $image;
            }

            $image = $image ? $hostUrl . '/attachment/' . $image : $hostUrl . $default;
        }

        return $image;
    }

    /**
     * 写入文件上传记录.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public static function uploadDb($file_name, $file_size, $file_type, $extension, $file_url = '', $group_id = 0, $storage = 'local')
    {
        $datas = [
            'storage' => $storage,
            'group_id' => $group_id,
            'file_url' => $file_url,
            'file_name' => $file_name,
            'file_size' => $file_size,
            'file_type' => $file_type,
            'extension' => $extension,
            'is_delete' => 0,
        ];

        loggingHelper::writeLog('ImageHelper', 'uploadDb', '文件存储记录', $datas);

        $UploadFile = new UploadFile();
        if ($UploadFile->load($datas, '') && $UploadFile->save()) {
            // 用户关联存储
            $file_id = $UploadFile->file_id;
            $DdUploadFileUsed = new DdUploadFileUsed();
            $DdUploadFileUsed->load([
                'file_id' => $file_id,
                'from_id' => 0,
                'from_type' => $storage,
                'user_id' => (int) Yii::$app->user->identity->id,
            ], '') && $DdUploadFileUsed->save();

            return $UploadFile;
        } else {
            $msg = ErrorsHelper::getModelError($UploadFile);
            loggingHelper::writeLog('ImageHelper', 'uploadDb', '错误记录', $msg);

            return $msg;
        }
    }
}
