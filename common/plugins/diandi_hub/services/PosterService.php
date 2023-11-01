<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-05 01:11:04
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-19 15:03:53
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\config\HubConfig;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Da\QrCode\Contracts\ErrorCorrectionLevelInterface;
use Da\QrCode\Label;
use Da\QrCode\QrCode;
use Yii;

class PosterService extends BaseService
{
    // 生成海报数据
    public static function CreatePainter($goods_id, $user_id, $url, $scene, $width = 300, $codeImg = false)
    {
        // 获取商品详情
        $detail = GoodsService::getDetail($goods_id, 0);

        $user = Yii::$app->service->commonMemberService->baseInfo(1);

        // 生成二维码
        if (!$codeImg) {
            $codeImg = self::CreateQrcode($url, $scene, $width);
        }

        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        $baseConf = HubConfig::findOne(1);

        $conf = [];
        $conf['background'] = ImageHelper::tomedia($baseConf['shareimg']);
        $conf['image'] = [
            // 商品主图
            [
                'url' => ImageHelper::tomedia($detail['thumb']),
                'left' => 16,
                'top' => 78,
                'width' => 318,
                'height' => 303,
                'radius' => 6,
                'opacity' => 100,
            ],
            // 头像
            [
                'url' => !empty($user['avatarUrl']) ? ImageHelper::tomedia($user['avatarUrl']) : $store['logo'],
                'left' => 15,
                'top' => 23,
                'width' => 42,
                'height' => 42,
                'radius' => '50%',
            ],
            // 二维码
            [
                'url' => $codeImg,
                'left' => 245,
                'top' => 410,
                'width' => 89,
                'height' => 89,
                // border: '1px solid #000',
                'radius' => '50%',
            ],
        ];

        // 商品名称长度处理
        $goods_name = StringHelper::msubstr($detail['goods_name'], 0, 26);

        $goods_name_len = StringHelper::strLength($goods_name);
        $title1 = $title2 = '';
        if ($goods_name_len > 13) {
            $title1 = StringHelper::msubstr($goods_name, 0, 13);
            $title2 = StringHelper::msubstr($goods_name, 13, 26);
        } else {
            $title1 = $detail['goods_name'];
        }

        $conf['text'] = [
            // 商品名称
            [
                'text' => $title1,
                'width' => '198',
                'fontColor' => '51,51,51',
                'left' => 21,
                'top' => 434,
                'fontSize' => 13,
                'angle' => 0,
            ],
            [
                'text' => $title2,
                'width' => '198',
                'fontColor' => '51,51,51',
                'left' => 21,
                'top' => 460,
                'fontSize' => 13,
                'angle' => 0,
            ],
            // 昵称
            [
                'text' => $user['username'],
                'fontColor' => '51,51,51',
                'left' => 72,
                'top' => 40,
                'fontSize' => 16,
                'angle' => 0,
            ],
            // 推荐话术
            [
                'text' => '为您挑选了一个好物',
                'fontColor' => '51,51,51',
                'left' => 72,
                'top' => 65,
                'fontSize' => 12,
                'angle' => 0.7,
            ],
            [
                'text' => '￥',
                'fontColor' => '255,0,0',
                'left' => 21,
                'top' => 496,
                'fontWeight' => 'bold',
                'fontSize' => 20,
                'lineHeight' => '.61em',
                'verticalAlign' => 'bottom',
            ],
            [
                'text' => $detail['goods_price'],
                'fontColor' => '255,0,0',
                'left' => 45,
                'top' => 496,
                'fontWeight' => 'bold',
                'fontSize' => 20,
                'lineHeight' => '.61em',
                'verticalAlign' => 'bottom',
            ],
        ];

        if (empty($title2)) {
            unset($conf['text'][1]);
        }

        return self::createPoster($conf, $scene, $user['invitation_code'] . '.png');
    }

    /**
     * 生成宣传海报.
     *
     * @param array  参数,包括图片和文字
     * @param string $filename 生成海报文件名,不传此参数则不生成文件,直接输出图片
     *
     * @return [type] [description]
     */
    public static function createPoster($config = [], $scene, $filename = '')
    {
        //如果要看报什么错，可以先注释调这个header
        if (empty($filename)) {
            header('content-type: image/png');
        }
        $imageDefault = [
            'left' => 0,
            'top' => 0,
            'right' => 0,
            'bottom' => 0,
            'width' => 100,
            'height' => 100,
            'opacity' => 100,
        ];
        $textDefault = [
            'text' => '',
            'left' => 0,
            'top' => 0,
            'fontSize' => 32,       //字号
            'fontColor' => '255,255,255', //字体颜色
            'angle' => 0,
        ];
        $background = $config['background']; //海报最底层得背景
        //背景方法
        $backgroundInfo = getimagesize($background);
        $backgroundFun = 'imagecreatefrom' . image_type_to_extension($backgroundInfo[2], false);
        $background = $backgroundFun($background);
        $backgroundWidth = imagesx($background);  //背景宽度
        $backgroundHeight = imagesy($background);  //背景高度
        $imageRes = imagecreatetruecolor($backgroundWidth, $backgroundHeight);

        $color = imagecolorallocate($imageRes, 0, 0, 0);
        imagefill($imageRes, 0, 0, $color);
        // imageColorTransparent($imageRes, $color);  //颜色透明
        imagecopyresampled($imageRes, $background, 0, 0, 0, 0, imagesx($background), imagesy($background), imagesx($background), imagesy($background));
        //处理了图片
        if (!empty($config['image'])) {
            foreach ($config['image'] as $key => $val) {
                $val = array_merge($imageDefault, $val);
                $info = getimagesize($val['url']);
                $function = 'imagecreatefrom' . image_type_to_extension($info[2], false);
                if ($val['stream']) {   //如果传的是字符串图像流
                    $info = getimagesizefromstring($val['url']);
                    $function = 'imagecreatefromstring';
                }
                $res = $function($val['url']);
                $resWidth = $info[0];
                $resHeight = $info[1];
                //建立画板 ，缩放图片至指定尺寸
                $canvas = imagecreatetruecolor($val['width'], $val['height']);
                imagefill($canvas, 0, 0, $color);
                //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
                imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'], $resWidth, $resHeight);
                $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) - $val['width'] : $val['left'];
                $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) - $val['height'] : $val['top'];
                //放置图像
                imagecopymerge($imageRes, $canvas, $val['left'], $val['top'], $val['right'], $val['bottom'], $val['width'], $val['height'], $val['opacity']); //左，上，右，下，宽度，高度，透明度
            }
        }

        $fontPath = Yii::getAlias('@addons/diandi_hub/assets/resource/font/msyhbd.ttf');

        //处理文字
        if (!empty($config['text'])) {
            foreach ($config['text'] as $key => $val) {
                $val = array_merge($textDefault, $val);
                list($R, $G, $B) = explode(',', $val['fontColor']);
                $fontColor = imagecolorallocate($imageRes, $R, $G, $B);
                $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) : $val['left'];
                $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) : $val['top'];
                $text = self::to_unicode($val['text']);
                imagettftext($imageRes, $val['fontSize'], $val['angle'], $val['left'], $val['top'], $fontColor, $fontPath, $text);
            }
        }

        $codePath = Yii::getAlias('@frontend/attachment/diandi_hub/codes/' . $scene);

        if (!is_dir($codePath)) {
            FileHelper::mkdirs($codePath);
        }

        //生成图片
        if (!empty($filename)) {
            $res = imagejpeg($imageRes, $codePath . '/' . $filename, 90); //保存到本地
            imagedestroy($imageRes);
            if (!$res) {
                return false;
            }

            return ImageHelper::tomedia('diandi_hub/codes/' . $scene . '/' . $filename);
        } else {
            imagejpeg($imageRes);     //在浏览器上显示
            imagedestroy($imageRes);
        }
    }

    public static function CreateQrcode($url, $scene, $width = 300)
   {

        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        $member_id = Yii::$app->user->identity->user_id;

        $baseInfo = Yii::$app->service->commonMemberService->baseInfo(1);

        $logo = $store['logopath']; //二维码内容

        $label = (new Label($baseInfo['username'] . '邀请你参与'))
            // ->useFont(__DIR__ . '/../resources/fonts/monsterrat.otf')
            ->setFontSize(12);

        $qrCode = (new QrCode($url))
            ->setLogo($logo)
            ->setForegroundColor(14, 14, 14)
            ->setBackgroundColor(255, 255, 255)
            ->setEncoding('UTF-8')
            ->setErrorCorrectionLevel(ErrorCorrectionLevelInterface::HIGH)
            ->setLogoWidth(60)
            ->setSize(300)
            ->setMargin(5)
            ->setLabel($label);

        $codePath = Yii::getAlias('@frontend/attachment/diandi_hub/codes/' . $scene);

        if (!is_dir($codePath)) {
            FileHelper::mkdirs($codePath);
        }

        if (file_exists($codePath . '/' . $member_id . '.png')) {
            $img = ImageHelper::tomedia('diandi_hub/codes/' . $scene . '/' . $member_id . '.png');

            return $img;
        }

        $qrCode->writeFile($codePath . '/' . $member_id . '.png');

        $img = ImageHelper::tomedia('diandi_hub/codes/' . $scene . '/' . $member_id . '.png');

        return $img;
    }

    public static function to_unicode($string)
    {
        $str = mb_convert_encoding($string, 'UCS-2', 'UTF-8');
        $arrstr = str_split($str, 2);
        $unistr = '';
        foreach ($arrstr as $n) {
            $dec = hexdec(bin2hex($n));
            $unistr .= '&#' . $dec . ';';
        }

        return $unistr;
    }
}
