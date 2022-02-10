<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-02 17:13:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-02 17:34:11
 */

namespace common\components\oss;

use OSS\Core\OssException;
use OSS\OssClient;
use Yii;
use yii\base\Component;

class Aliyunoss extends Component
{
    public static $oss;

    public function __construct()
    {
        parent::__construct();
        $accessKeyId = Yii::$app->params['oss']['accessKeyId'];                 //获取阿里云oss的accessKeyId
        $accessKeySecret = Yii::$app->params['oss']['accessKeySecret'];         //获取阿里云oss的accessKeySecret
        $endpoint = Yii::$app->params['oss']['endPoint'];                       //获取阿里云oss的endPoint
        self::$oss = new OssClient($accessKeyId, $accessKeySecret, $endpoint);  //实例化OssClient对象
    }

    //删除文件/或文件夹
    public function del_file()
    {
        $res = false;
        $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket
        if (self::$oss->deleteObject($bucket, 'wocao/')) {
            //调用deleteObject方法把服务器文件上传到阿里云oss
            $res = true;
        }

        return $res;
    }

    //上传文件
    public function upload_file()
    {
        try {
            $bucket = Yii::$app->params['oss']['bucket'];
            $a = self::$oss->uploadFile($bucket, time().'.'.'png', 'kwk.png');
            print_r($a);
            echo 'success';
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
    }

    //下载文件
    public function down_file()
    {
        $localfile = 'yuzengyuan.'.'jpg';

        $options = [
            OssClient::OSS_FILE_DOWNLOAD => $localfile,
        ];
        try {
            $bucket = Yii::$app->params['oss']['bucket'];
            self::$oss->getObject($bucket, '1513585444.png', $options);
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        echo __FUNCTION__.': OK, '.$localfile."\n";
    }

    //判断是否存在文件
    public function doesObjectExist()
    {
        try {
            $bucket = Yii::$app->params['oss']['bucket'];
            $exist = self::$oss->doesObjectExist($bucket, $object);
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        echo __FUNCTION__.': OK'."\n";
        var_dump($exist);
    }

    //创建虚拟目录
    public function create_dir()
    {
        try {
            self::$oss->createObjectDir('budfesdfd', 'dirrrr');
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        echo __FUNCTION__.': OK'."\n";
    }

    //删除虚拟目录
    public function createObjectDir()
    {
        try {
            $bucket = Yii::$app->params['oss']['bucket'];
            self::$oss->createObjectDir($bucket, 'phpyuzengyuan');
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        echo __FUNCTION__.': OK'."\n";
    }

    //列出用户所有的存储空间
    public function listBuckets()
    {
        $bucketList = null;
        try {
            $bucketListInfo = self::$oss->listBuckets();
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        $bucketList = $bucketListInfo->getBucketList();
        foreach ($bucketList as $bucket) {
            echo $bucket->getLocation().'<br>'.$bucket->getName().'<br>'.$bucket->getCreatedate().'<br>';
            echo '<hr>';
        }
    }

    //创建储存空间
    public function create_Bucket()
    {
        try {
            self::$oss->createBucket('budfesdfd');
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        echo 'success';
    }

    //删除存储空间
    public function deleteBucket()
    {
        try {
            self::$oss->deleteBucket('yuzengbdfds');
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        echo __FUNCTION__.': OK'."\n";
    }

    //判断存储空间是否存在
    public function doesBucketExist()
    {
        try {
            $res = self::$oss->doesBucketExist('budfe1sdfd');
        } catch (OssException $e) {
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");

            return;
        }
        if ($res === true) {
            echo __FUNCTION__.': OK'."\n";
        } else {
            echo __FUNCTION__.': FAILED'."\n";
        }
    }
}
