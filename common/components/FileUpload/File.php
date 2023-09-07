<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-31 13:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:26:52
 */

namespace common\components\oss;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\BaseObject;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * File 文件处理
 *
 */
class File extends BaseObject
{
    /**
     * @string 文件路径
     */
    protected mixed $path;

    /**
     * 文件扩展
     * @var string
     */
    protected string $extension;

    /**
     * 文件大小
     * @var int
     */
    protected int $size;

    /**
     * 文件类型
     * @var string
     */
    protected string $mimeType;

    /**
     * 路径信息
     * @var array
     */
    protected array $pathinfo;

    /**
     * 上传文件
     *
     * @param $file UploadedFile|string
     * @return object|array|string
     * @throws InvalidConfigException
     */
    public static function create(UploadedFile|string $file): object|array|string
    {
        if (is_a($file, self::className())) {
            return $file;
        }

        //上传文件
        if (is_a($file, UploadedFile::className())) {
            if ($file->error) {
                throw new InvalidParamException("File upload error \"{$file->error}\"");
            }

            return \Yii::createObject([
                'class'=>self::className(),
                'path'=>$file->tempName,
                'extension'=>$file->getExtension()
            ]);
        } else {
            return \Yii::createObject([
                'class' => self::className(),
                'path' => FileHelper::normalizePath($file)
            ]);
        }
    }

    /**
     * 上传多个文件
     *
     * @param array $files 文件数组
     * @return self[]
     * @throws \yii\base\InvalidConfigException
     */
    public static function createAll(array $files): array
    {
        $result = [];
        foreach ($files as $file) {
            $result[] = self::create($file);
        }
        return $result;
    }

    /**
     * 初始化
     *
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        if ($this->path === null) {
            throw new InvalidConfigException;
        }
    }

    /**
     * 获取文件路径
     *
     * @return mixed
     */
    public function getPath(): mixed
    {
        return $this->path;
    }

    /**
     * 获取文件大小
     *
     * @return int|bool
     */
    public function getSize(): int|bool
    {
        if (!$this->size) {
            $this->size = filesize($this->path);
        }
        return $this->size;
    }

    /**
     * 获取文件类型
     *
     * @return string
     * @throws InvalidConfigException
     */
    public function getMimeType(): string
    {
        if (!$this->mimeType) {
            $this->mimeType = FileHelper::getMimeType($this->path);
        }
        return $this->mimeType;
    }

    /**
     * 获取文件扩展
     *
     * @return string
     */
    public function getExtension(): string
    {

        return $this->extension;
    }

    /**
     * 获取文件类型
     *
     * @return mixed
     * @throws InvalidConfigException
     */
    public function getExtensionByMimeType(): mixed
    {
        $extensions = FileHelper::getExtensionsByMimeType($this->getMimeType());
        return array_shift($extensions);
    }

    /**
     * 获取路径信息
     *
     * @param bool $part
     * @return mixed|null
     */
    public function getPathInfo(bool $part = false): mixed
    {
        if ($part !== false) {
            return array_key_exists($part, $this->pathinfo) ? $this->pathinfo[$part] : null;
        }
        return $this->pathinfo;
    }

    /**
     * 设置路径
     *
     * @param $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * 设置扩展
     *
     * @param $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * 是否发生错误
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->error !== false;
    }
}
