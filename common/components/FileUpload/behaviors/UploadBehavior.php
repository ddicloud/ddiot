<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-31 13:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:12:17
 */

namespace common\components\oss\storage\behaviors;

use common\components\oss\Storage;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

/**
 * UploadBehavior 上传动作
 *
 */
class UploadBehavior extends Behavior
{
    /**
     * @var 拥有者
     */
    public $owner;

    /**
     * @var string 字段名
     */
    public $attribute = 'file';

    /**
     * @var bool 多个文件上传
     */
    public $multiple = false;

    /**
     * @var string prefix
     */
    public $attributePrefix;

    /**
     * @var string 地址
     */
    public $attributePathName = 'path';

    /**
     * @var string 文件基础地址
     */
    public $attributeBaseUrlName = 'base_url';

    /**
     * @var string 路径
     */
    public $pathAttribute;

    /**
     * @var string 基础路径字段
     */
    public $baseUrlAttribute;

    /**
     * @var string 类型
     */
    public $typeAttribute;

    /**
     * @var string 大小
     */
    public $sizeAttribute;

    /**
     * @var string 名称
     */
    public $nameAttribute;

    /**
     * @var string 订单
     */
    public $orderAttribute;

    /**
     * @var string 上传关系
     */
    public $uploadRelation;

    /**
     * @var $uploadModel
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
    public $uploadModel;

    /**
     * @var string 上传场景
     */
    public $uploadModelScenario = 'default';

    /**
     * @var mixed|string
     * Filestorage component name or Yii2 compatible object configuration
     */
    public $filesStorage = 'fileStorage';

    /**
     * @var array 删除路径
     */
    protected $deletePaths;

    /**
     * @var \yiiplus\storage\Storage
     */
    protected $storage;

    /**
     * 事件
     *
     * @return array
     */
    public function events()
    {
        $multipleEvents = [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindMultiple',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsertMultiple',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateMultiple',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteMultiple',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        $singleEvents = [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindSingle',
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidateSingle',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdateSingle',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateSingle',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteSingle',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        return $this->multiple ? $multipleEvents : $singleEvents;
    }

    /**
     * 规则
     *
     * @return array
     */
    public function fields()
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
     */
    public function afterValidateSingle()
    {
        $this->loadModel($this->owner, $this->owner->{$this->attribute});
    }

    /**
     * 插入后事件
     *
     * @return void
     */
    public function afterInsertMultiple()
    {
        if ($this->owner->{$this->attribute}) {
            $this->saveFilesToRelation($this->owner->{$this->attribute});
        }
    }

    /**
     * 更新后事件
     *
     * @throws \Exception
     */
    public function afterUpdateMultiple()
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
     */
    public function beforeUpdateSingle()
    {
        $this->deletePaths = $this->owner->getOldAttribute($this->getAttributeField('path'));
    }

    /**
     * 更新后
     *
     * @return void
     */
    public function afterUpdateSingle()
    {
        $path = $this->owner->getAttribute($this->getAttributeField('path'));
        if (!empty($this->deletePaths) && $this->deletePaths !== $path) {
            $this->deleteFiles();
        }
    }

    /**
     * 删除后
     *
     * @return void
     */
    public function beforeDeleteMultiple()
    {
        $this->deletePaths = ArrayHelper::getColumn($this->getUploaded(), 'path');
    }

    /**
     * 删除前
     *
     * @return void
     */
    public function beforeDeleteSingle()
    {
        $this->deletePaths = $this->owner->getAttribute($this->getAttributeField('path'));
    }

    /**
     * 删除后
     *
     * @return void
     */
    public function afterDelete()
    {
        $this->deletePaths = is_array($this->deletePaths) ? array_filter($this->deletePaths) : $this->deletePaths;
        $this->deleteFiles();
    }

    /**
     * 查询后
     *
     * @return void
     */
    public function afterFindMultiple()
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
     */
    public function afterFindSingle()
    {
        $file = array_map(function ($attribute) {
            return $this->owner->getAttribute($attribute);
        }, $this->fields());
        if ($file['path'] !== null && $file['base_url'] === null){
            $file['base_url'] = $this->getStorage()->baseUrl;
        }
        if (array_key_exists('path', $file) && $file['path']) {
            $this->owner->{$this->attribute} = $this->enrichFileData($file);
        }
    }

    /**
     * 获取上传模型
     *
     * @return string
     */
    public function getUploadModelClass()
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
     */
    protected function saveFilesToRelation($files)
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
     */
    protected function updateFilesInRelation($files)
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
     * @return \yiiplus\storage\Storage
     * @throws \yii\base\InvalidConfigException
     */
    protected function getStorage()
    {
        if (!$this->storage) {
            $this->storage = Instance::ensure($this->filesStorage, Storage::className());
        }
        return $this->storage;

    }

    /**
     * 获取已上传
     *
     * @return array
     */
    protected function getUploaded()
    {
        $files = $this->owner->{$this->attribute};
        return $files ?: [];
    }

    /**
     * 获取上传关系
     *
     * @return \yii\db\ActiveQuery|\yii\db\ActiveQueryInterface
     */
    protected function getUploadRelation()
    {
        return $this->owner->getRelation($this->uploadRelation);
    }

    /**
     * 加载模型
     *
     * @param $model \yii\db\ActiveRecord
     * @param $data
     * @return \yii\db\ActiveRecord
     */
    protected function loadModel(&$model, $data)
    {
        $attributes = array_flip($model->attributes());
        foreach ($this->fields() as $dataField => $modelField) {
            if ($modelField && array_key_exists($modelField, $attributes)) {
                $model->{$modelField} =  ArrayHelper::getValue($data, $dataField);
            }
        }
        return $model;
    }

    /**
     * 获取属性
     *
     * @param $type
     * @return mixed
     */
    protected function getAttributeField($type)
    {
        return ArrayHelper::getValue($this->fields(), $type, false);
    }

    /**
     * 删除文件
     *
     * @return bool|void
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
     */
    protected function enrichFileData($file)
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
