<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-31 13:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:12:17
 */

namespace common\components\oss\storage\behaviors;

use common\components\oss\Storage;
use ErrorException;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

/**
 * UploadBehavior 上传动作
 *
 */
class UploadBehavior extends Behavior
{
    /**
     * @var
     */
    public  $owner;

    /**
     * @var string 字段名
     */
    public string $attribute = 'file';

    /**
     * @var bool 多个文件上传
     */
    public bool $multiple = false;

    /**
     * @var string prefix
     */
    public string $attributePrefix;

    /**
     * @var string 地址
     */
    public string $attributePathName = 'path';

    /**
     * @var string 文件基础地址
     */
    public string $attributeBaseUrlName = 'base_url';

    /**
     * @var string 路径
     */
    public string $pathAttribute;

    /**
     * @var string 基础路径字段
     */
    public string $baseUrlAttribute;

    /**
     * @var string 类型
     */
    public string $typeAttribute;

    /**
     * @var string 大小
     */
    public string $sizeAttribute;

    /**
     * @var string 名称
     */
    public string $nameAttribute;

    /**
     * @var string 订单
     */
    public string $orderAttribute;

    /**
     * @var string 上传关系
     */
    public string $uploadRelation;

    /**
     * @var  ActiveRecord
     * Schema example:
     *      `id` INT NOT NULL AUTO_INCREMENT,
     *      `path` VARCHAR(1024) NOT NULL,
     *      `base_url` VARCHAR(255) NULL,
     *      `type` VARCHAR(255) NULL,
     *      `size` INT NULL,
     *      `name` VARCHAR(255) NULL,
     *      `order` INT NULL,
     *      `foreign_key_id` INT NOT NULL,
     */
    public ActiveRecord $uploadModel;

    /**
     * @var string 上传场景
     */
    public string $uploadModelScenario = 'default';

    /**
     * @var mixed|string
     * Filestorage component name or Yii2 compatible object configuration
     */
    public mixed $filesStorage = 'fileStorage';

    /**
     * @var array 删除路径
     */
    protected array $deletePaths;


    protected $storage;

    /**
     * 事件
     *
     * @return array
     */
    public function events(): array
    {
        $multipleEvents = [
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFindMultiple',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterInsertMultiple',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateMultiple',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteMultiple',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        $singleEvents = [
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFindSingle',
            Model::EVENT_AFTER_VALIDATE => 'afterValidateSingle',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdateSingle',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateSingle',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteSingle',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        return $this->multiple ? $multipleEvents : $singleEvents;
    }

    /**
     * 规则
     *
     * @return array
     */
    public function fields(): array
    {
        $fields = [
            $this->attributePathName ? : 'path' => $this->pathAttribute,
            $this->attributeBaseUrlName ? : 'base_url' => $this->baseUrlAttribute,
            'type' => $this->typeAttribute,
            'size' => $this->sizeAttribute,
            'name' => $this->nameAttribute,
            'order' => $this->orderAttribute
        ];

        if ($this->attributePrefix !== null) {
            $fields = array_map(function ($fieldName) {
                return $this->attributePrefix . $fieldName;
            }, $fields);
        }

        return $fields;
    }

    /**
     * 验证后
     *
     * @return void
     * @throws ErrorException
     */
    public function afterValidateSingle(): void
    {
        try {
            $this->loadModel($this->owner, $this->owner->{$this->attribute});
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * 插入后事件
     *
     * @return void
     * @throws ErrorException
     */
    public function afterInsertMultiple(): void
    {
        if ($this->owner->{$this->attribute}) {
            try {
                $this->saveFilesToRelation($this->owner->{$this->attribute});
            } catch (ErrorException $e) {
                throw new ErrorException($e->getMessage());
            }
        }
    }

    /**
     * 更新后事件
     *
     * @throws \Exception
     */
    public function afterUpdateMultiple(): void
    {
        $filesPaths = ArrayHelper::getColumn($this->getUploaded(), 'path');
        $models = $this->owner->getRelation($this->uploadRelation)->all();
        $modelsPaths = ArrayHelper::getColumn($models, $this->getAttributeField('path'));
        $newFiles = $updatedFiles = [];
        foreach ($models as $model) {
            $path = $model->getAttribute($this->getAttributeField('path'));
            if (!in_array($path, $filesPaths, true) && $model->delete()) {
                $this->getStorage()->delete($path);
            }
        }
        foreach ($this->getUploaded() as $file) {
            if (!in_array($file['path'], $modelsPaths, true)) {
                $newFiles[] = $file;
            } else {
                $updatedFiles[] = $file;
            }
        }
        $this->saveFilesToRelation($newFiles);
        $this->updateFilesInRelation($updatedFiles);
    }

    /**
     * 更新前
     *
     * @return void
     * @throws ErrorException
     */
    public function beforeUpdateSingle(): void
    {
        $this->deletePaths = $this->owner->getOldAttribute($this->getAttributeField('path'));
    }

    /**
     * 更新后
     *
     * @return void
     * @throws ErrorException
     */
    public function afterUpdateSingle(): void
    {
        try {
            $path = $this->owner->getAttribute($this->getAttributeField('path'));

            if (!empty($this->deletePaths) && $this->deletePaths !== $path) {
                $this->deleteFiles();
            }
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());

        }
    }

    /**
     * 删除后
     *
     * @return void
     */
    public function beforeDeleteMultiple(): void
    {
        $this->deletePaths = ArrayHelper::getColumn($this->getUploaded(), 'path');
    }

    /**
     * 删除前
     *
     * @return void
     * @throws ErrorException
     */
    public function beforeDeleteSingle(): void
    {
        try {
            $this->deletePaths = $this->owner->getAttribute($this->getAttributeField('path'));
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * 删除后
     *
     * @return void
     * @throws ErrorException
     */
    public function afterDelete(): void
    {
        $this->deletePaths = is_array($this->deletePaths) ? array_filter($this->deletePaths) : $this->deletePaths;
        try {
            $this->deleteFiles();
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * 查询后
     *
     * @return void
     * @throws ErrorException
     * @throws \Exception
     */
    public function afterFindMultiple(): void
    {
        $models = $this->owner->{$this->uploadRelation};
        $fields = $this->fields();
        $data = [];
        foreach ($models as $k => $model) {
            /* @var $model \yii\db\BaseActiveRecord */
            $file = [];
            foreach ($fields as $dataField => $modelAttribute) {
                $file[$dataField] = $model->hasAttribute($modelAttribute)
                    ? ArrayHelper::getValue($model, $modelAttribute)
                    : null;
            }
            if ($file['path']) {
                $data[$k] = $this->enrichFileData($file);
            }

        }
        $this->owner->{$this->attribute} = $data;
    }

    /**
     * 查询后
     *
     * @return void
     * @throws InvalidConfigException
     * @throws ErrorException
     */
    public function afterFindSingle(): void
    {
        $file = array_map(function ($attribute) {
            return $this->owner->getAttribute($attribute);
        }, $this->fields());
        if ($file['path'] !== null && $file['base_url'] === null){
            try {
                $file['base_url'] = $this->getStorage()->baseUrl;
            } catch (ErrorException $e) {
                throw new ErrorException($e->getMessage());
            }
        }
        if (array_key_exists('path', $file) && $file['path']) {
            $this->owner->{$this->attribute} = $this->enrichFileData($file);
        }
    }

    /**
     * 获取上传模型
     *
     * @return string|ActiveRecord
     */
    public function getUploadModelClass(): string|ActiveRecord
    {
        if (!$this->uploadModel) {
            $this->uploadModel = $this->getUploadRelation()->modelClass;
        }
        return $this->uploadModel;
    }

    /**
     * 保存文件关系
     *
     * @param array $files
     * @throws ErrorException
     */
    protected function saveFilesToRelation(array $files): void
    {
        $modelClass = $this->getUploadModelClass();
        foreach ($files as $file) {
            $model = new $modelClass;
            $model->setScenario($this->uploadModelScenario);
            $model = $this->loadModel($model, $file);
            if ($this->getUploadRelation()->via !== null) {
                $model->save(false);
            }
            $this->owner->link($this->uploadRelation, $model);
        }
    }

    /**
     * 更新文件关系
     *
     * @param array $files
     * @throws ErrorException
     */
    protected function updateFilesInRelation(array $files): void
    {
        $modelClass = $this->getUploadModelClass();
        foreach ($files as $file) {
            $model = $modelClass::findOne([$this->getAttributeField('path') => $file['path']]);
            if ($model) {
                $model->setScenario($this->uploadModelScenario);
                $model = $this->loadModel($model, $file);
                $model->save(false);
            }
        }
    }

    /**
     * 获取上传
     *
     *
     * @throws ErrorException
     */
    protected function getStorage()
    {
        if (!$this->storage) {
            try {
                $this->storage = Instance::ensure($this->filesStorage, Storage::className());
            } catch (InvalidConfigException $e) {
                throw new ErrorException($e->getMessage());
            }
        }
        return $this->storage;

    }

    /**
     * 获取已上传
     *
     * @return array
     */
    protected function getUploaded(): array
    {
        $files = $this->owner->{$this->attribute};
        return $files ?: [];
    }

    /**
     * 获取上传关系
     *
     * @return \yii\db\ActiveQuery|\yii\db\ActiveQueryInterface
     */
    protected function getUploadRelation(): \yii\db\ActiveQueryInterface|\yii\db\ActiveQuery
    {
        return $this->owner->getRelation($this->uploadRelation);
    }

    /**
     * 加载模型
     *
     * @param $model \yii\db\ActiveRecord
     * @param $data
     * @return \yii\db\ActiveRecord
     * @throws ErrorException
     */
    protected function loadModel(ActiveRecord &$model, $data): ActiveRecord
    {
        $attributes = array_flip($model->attributes());
        foreach ($this->fields() as $dataField => $modelField) {
            if ($modelField && array_key_exists($modelField, $attributes)) {
                try {
                    $model->{$modelField} = ArrayHelper::getValue($data, $dataField);
                } catch (\Exception $e) {
                    throw new ErrorException($e->getMessage());
                }
            }
        }
        return $model;
    }

    /**
     * 获取属性
     *
     * @param $type
     * @return mixed
     * @throws ErrorException
     */
    protected function getAttributeField($type): mixed
    {
        try {
            return ArrayHelper::getValue($this->fields(), $type, false);
        } catch (\Exception $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * 删除文件
     *
     * @return bool|void
     * @throws ErrorException
     */
    protected function deleteFiles()
    {
        $storage = $this->getStorage();
        if ($this->deletePaths !== null) {
            return is_array($this->deletePaths)
                ? $storage->deleteAll($this->deletePaths)
                : $storage->delete($this->deletePaths);
        }
        return true;
    }

    /**
     * 丰富文件数据
     *
     * @param $file
     * @return mixed
     * @throws ErrorException
     */
    protected function enrichFileData($file): mixed
    {
        $fs = $this->getStorage()->getFilesystem();
        if ($file['path'] && $fs->has($file['path'])) {
            $data = [
                'type' => $fs->getMimetype($file['path']),
                'size' => $fs->getSize($file['path']),
                'timestamp' => $fs->getTimestamp($file['path'])
            ];
            foreach ($data as $k => $v) {
                if (!array_key_exists($k, $file) || !$file[$k]) {
                    $file[$k] = $v;
                }
            }
        }
        if ($file['path'] !== null && $file['base_url'] === null) {
            $file['base_url'] = $this->getStorage()->baseUrl;
        }
        return $file;
    }
}
