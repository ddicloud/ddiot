<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-31 13:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:16:42
 */

namespace common\components\oss;

use Yii;
use common\components\oss\events\StorageEvent;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

/**
 * Storage 文件上传核心类
 *
 */
class Storage extends Component
{
    /**
     * 删除前事件
     */
    const EVENT_BEFORE_DELETE = 'beforeDelete';

    /**
     * 保存前事件
     */
    const EVENT_BEFORE_SAVE = 'beforeSave';

    /**
     * 删除后事件
     */
    const EVENT_AFTER_DELETE = 'afterDelete';

    /**
     * 保存后事件
     */
    const EVENT_AFTER_SAVE = 'afterSave';

    /**
     * @var 文件域名
     */
    public $baseUrl;

    /**
     * @var string
     */
    public $basePath = '';

    /**
     * @var 文件系统
     */
    protected $filesystem;

    /**
     * @var int 目录最大文件数 -1无限制
     */
    public $maxDirFiles = 65535;

    /**
     * @var int 是否开启索引目录
     */
    public $openDirIndex = 0;

    /**
     * @var int 文件索引
     */
    private $_dirindex = 1;

    /**
     * 初始化
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->baseUrl !== null) {
            $this->baseUrl = Yii::getAlias($this->baseUrl);
        }

        $this->filesystem = Yii::createObject($this->filesystem);
        if ($this->filesystem instanceof FilesystemBuilderInterface) {
            $this->filesystem = $this->filesystem->build();
        }
    }

    /**
     * 获取文件系统
     *
     * @return mixed
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * 设置文件系统
     *
     * @param $filesystem
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * 上传文件
     *
     * @param file   $file             上传文件
     * @param string $pathPrefix       目录名
     * @param bool   $preserveFileName 是否保留文件名
     * @param bool   $overwrite        新建还是更改
     * @param array  $config           其他请求头配置
     *
     * @return bool|string
     * @throws InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function save($file, $pathPrefix = '', $preserveFileName = false, $overwrite = false, $config = [])
    {
        if (empty($file)) {
            return false;
        }
        $basePath = $this->basePath ? $this->basePath . DIRECTORY_SEPARATOR : '';
        $pathPrefix = FileHelper::normalizePath($basePath . $pathPrefix);

        $fileObj = File::create($file);
        $dirIndex = $this->getDirIndex($pathPrefix);

        if ($preserveFileName === false) {
            do {
                $filename = implode('.', [
                    Yii::$app->security->generateRandomString(),
                    $fileObj->getExtension()
                ]);
                $pathArr = [$pathPrefix, $dirIndex, $filename];
                $implodeArr = array_filter($pathArr);
                $path = implode(DIRECTORY_SEPARATOR, $implodeArr);
            } while ($this->getFilesystem()->has($path));
        } else {
            $filename = $fileObj->getPathInfo('filename');
            $pathArr = [$pathPrefix, $dirIndex, $filename];
            $implodeArr = array_filter($pathArr);
            $path = implode(DIRECTORY_SEPARATOR, $implodeArr);
        }

        $this->beforeSave($fileObj->getPath(), $this->getFilesystem());

        $stream = fopen($fileObj->getPath(), 'rb+');
        $config = array_merge(['ContentType' => $fileObj->getMimeType()], $config);
        if ($overwrite) {
            $success = $this->getFilesystem()->putStream($path, $stream, $config);
        } else {
            $success = $this->getFilesystem()->writeStream($path, $stream, $config);
        }

		if (is_resource($stream)) {
			fclose($stream);
		}

        if ($success) {
            $this->afterSave($path, $this->getFilesystem());

            return DIRECTORY_SEPARATOR . $path;
        }

        return false;
    }

    /**
     * 批量保存
     *
     * @param file   $file             上传文件
     * @param string $pathPrefix       目录名
     * @param bool   $preserveFileName 是否保留文件名
     * @param bool   $overwrite        新建还是更改
     * @param array  $config           其他请求头配置
     *
     * @return array
     * @throws InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function saveAll($files, $pathPrefix, $preserveFileName = false, $overwrite = false, array $config = [])
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $this->save($file, $pathPrefix, $preserveFileName, $overwrite, $config);
        }
        return $paths;
    }

    /**
     * 删除文件
     *
     * @param string $path 文件路径
     *
     * @return bool
     * @throws InvalidConfigException
     */
    public function delete($path)
    {
        if ($this->getFilesystem()->has($path)) {
            $this->beforeDelete($path, $this->getFilesystem());
            if ($this->getFilesystem()->delete($path)) {
                $this->afterDelete($path, $this->getFilesystem());
                return true;
            };
        }
        return false;
    }

    /**
     * 批量删除
     *
     * @param array $files 文件路径数组
     *
     * @throws InvalidConfigException
     */
    public function deleteAll($files)
    {
        foreach ($files as $file) {
            $this->delete($file);
        }

    }

    /**
     * 获取文件存储子目录
     *
     * @param string $path 文件路径
     *
     * @return int
     */
    protected function getDirIndex($path = '')
    {
        //默认不开启索引
        if ($this->openDirIndex == 0) {
            return '';
        }
        $normalizedPath = '.dirindex';
        if (isset($path)) {
            $normalizedPath = $path . DIRECTORY_SEPARATOR . '.dirindex';
        }

        if (!$this->getFilesystem()->has($normalizedPath)) {
            $this->getFilesystem()->write($normalizedPath, (string) $this->_dirindex);
        } else {
            $this->_dirindex = $this->getFilesystem()->read($normalizedPath);
            if ($this->maxDirFiles !== -1) {
                $filesCount = count($this->getFilesystem()->listContents($this->_dirindex));
                if ($filesCount > $this->maxDirFiles) {
                    $this->_dirindex++;
                    $this->getFilesystem()->put($normalizedPath, (string) $this->_dirindex);
                }
            }
        }

        return $this->_dirindex;
    }

    /**
     * 触发文件系统保存前事件
     *
     * @param string $path       文件路径
     * @param null   $filesystem 文件系统
     *
     * @throws InvalidConfigException
     */
    public function beforeSave($path, $filesystem = null)
    {
        $event = Yii::createObject([
            'class' => StorageEvent::className(),
            'path' => $path,
            'filesystem' => $filesystem
        ]);

        $this->trigger(self::EVENT_BEFORE_SAVE, $event);
    }

    /**
     * 触发文件系统保存后事件
     *
     * @param string $path       文件路径
     * @param null   $filesystem 文件系统
     *
     * @throws InvalidConfigException
     */
    public function afterSave($path, $filesystem)
    {
        $event = Yii::createObject([
            'class' => StorageEvent::className(),
            'path' => $path,
            'filesystem' => $filesystem
        ]);
        $this->trigger(self::EVENT_AFTER_SAVE, $event);
    }

    /**
     * 触发文件系统删除前事件
     *
     * @param string $path       文件路径
     * @param null   $filesystem 文件系统
     *
     * @throws InvalidConfigException
     */
    public function beforeDelete($path, $filesystem)
    {
        $event = Yii::createObject([
            'class' => StorageEvent::className(),
            'path' => $path,
            'filesystem' => $filesystem
        ]);
        $this->trigger(self::EVENT_BEFORE_DELETE, $event);
    }

    /**
     * 触发文件系统删除后事件
     *
     * @param string $path       文件路径
     * @param null   $filesystem 文件系统
     *
     * @throws InvalidConfigException
     */
    public function afterDelete($path, $filesystem)
    {
        $event = Yii::createObject([
            'class' => StorageEvent::className(),
            'path' => $path,
            'filesystem' => $filesystem
        ]);
        $this->trigger(self::EVENT_AFTER_DELETE, $event);
    }
}
