<?php
/**
 * @Author: Wang chunsheng  &#60;2192138785@qq.com&#62;
 * @Date:   2020-04-29 19:56:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-26 18:24:58
 */

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace addonstpl\adminapi;

use common\helpers\FileHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\ColumnSchema;
use yii\db\Connection;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controllers ID (without the module ID prefix). This property is
 * read-only.
 * @property string $nameAttribute This property is read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property bool|TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controllers view path. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    public $moduleID;

    public $modelClass;

    public $controllerClass;

    public $viewPath;

    public $baseControllerClass = 'yii\web\Controller';

    public $indexWidgetType = 'grid';

    public $searchModelClass = '';

    /**
     * @var bool whether to wrap the `GridView` or `ListView` widget with the `yii\widgets\Pjax` widget
     * @since 2.0.5
     */
    public $enablePjax = false;

    /**
     * @var bool whether to use strict inflection for controllers IDs (insert a separator between two consecutive uppercase chars)
     * @since 2.1.0
     */
    public $strictInflector = true;


    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return '后台管理接口生成';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return '这个生成器生成实现CRUD(创建、读取、更新、删除)的控制器。指定数据模型的操作。';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['controllerClass', 'modelClass', 'searchModelClass', 'baseControllerClass'], 'filter', 'filter' => 'trim', 'skipOnEmpty' => true],
            [['modelClass', 'controllerClass', 'baseControllerClass', 'indexWidgetType'], 'required'],
            [['searchModelClass'], 'compare', 'compareAttribute' => 'modelClass', 'operator' => '!==', 'message' => 'Search Model Class must not be equal to Model Class.'],
            [['modelClass', 'controllerClass', 'baseControllerClass', 'searchModelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['modelClass'], 'validateClass', 'params' => ['extends' => BaseActiveRecord::className()]],
            [['baseControllerClass'], 'validateClass', 'params' => ['extends' => Controller::className()]],
            [['controllerClass'], 'match', 'pattern' => '/Controller$/', 'message' => 'Controller class name must be suffixed with "Controller".'],
            [['controllerClass'], 'match', 'pattern' => '/(^|\\\\)[A-Z][^\\\\]+Controller$/', 'message' => 'Controller class name must start with an uppercase letter.'],
            [['controllerClass', 'searchModelClass'], 'validateNewClass'],
            [['indexWidgetType'], 'in', 'range' => ['grid', 'list']],
            [['modelClass'], 'validateModelClass'],
            [['enableI18N', 'enablePjax'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
            ['viewPath', 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'modelClass' => 'Model Class',
            'controllerClass' => 'Controller Class',
            'viewPath' => 'View Path',
            'baseControllerClass' => 'Base Controller Class',
            'indexWidgetType' => 'Widget Used in Index Page',
            'searchModelClass' => 'Search Model Class',
            'enablePjax' => 'Enable Pjax',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function hints(): array
    {
        return array_merge(parent::hints(), [
            'modelClass' => 'This is the ActiveRecord class associated with the table that CRUD will be built upon.
                You should provide a fully qualified class name, e.g., <code>App\models\Post</code>.',
            'controllerClass' => 'This is the name of the controllers class to be generated. You should
                provide a fully qualified namespaced class (e.g. <code>App\controllers\PostController</code>),
                and class name should be in CamelCase with an uppercase first letter. Make sure the class
                is using the same namespace as specified by your application\'s controllerNamespace property.',
            'viewPath' => 'Specify the directory for storing the view scripts for the controllers. You may use path alias here, e.g.,
                <code>/var/www/basic/controllers/views/post</code>, <code>@App/views/post</code>. If not set, it will default
                to <code>@App/views/ControllerID</code>',
            'baseControllerClass' => 'This is the class that the new CRUD controllers class will extend from.
                You should provide a fully qualified class name, e.g., <code>yii\web\Controller</code>.',
            'indexWidgetType' => 'This is the widget type to be used in the index page to display list of the models.
                You may choose either <code>GridView</code> or <code>ListView</code>',
            'searchModelClass' => 'This is the name of the search model class to be generated. You should provide a fully
                qualified namespaced class name, e.g., <code>App\models\PostSearch</code>.',
            'enablePjax' => 'This indicates whether the generator should wrap the <code>GridView</code> or <code>ListView</code>
                widget on the index page with <code>yii\widgets\Pjax</code> widget. Set this to <code>true</code> if you want to get
                sorting, filtering and pagination without page refreshing.',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates(): array
    {
        return ['controllers.php'];
    }

    /**
     * {@inheritdoc}
     */
    public function stickyAttributes(): array
    {
        return array_merge(parent::stickyAttributes(), ['baseControllerClass', 'indexWidgetType']);
    }

    /**
     * Checks if model class is valid
     */
    public function validateModelClass(): void
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();
        if (empty($pk)) {
            $this->addError('modelClass', "The table associated with $class must have primary key(s).");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): array
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->controllerClass, '\\')) . '.php');

        $files = [
            new CodeFile($controllerFile, $this->render('controllers.php')),
        ];

        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
            $files[] = new CodeFile($searchModel, $this->render('search.php'));
        }

        //生成vue页面
        $viewPath = $this->getViewPath();

        $files[] = new CodeFile(
            $viewPath . '/api.js',
            $this->render('vue/api.js')
        );

//        $initParams = $this->createInitParams();

        $initContent = $this->render('vue/init.js');

        //获取字段
        $searchModelClass = explode('\\',$this->searchModelClass);

        $attributeLabels = (new $this->modelClass)->attributeLabels();
        $tableColumns = [];
        $fieldList = [];
        $form = [
            'blocs'=>[
                'type'=> 'cascader-store',
                'label' => '选择公司'
            ]
        ];

        $getPrimaryKey = (new $this->modelClass)->getPrimaryKey();
        $pathApi = "'".'/'.$this->moduleID.'/'. $this->getControllerID()."'";
        foreach ($attributeLabels as $prop=> $label) {
            $tableColumns[]= [
                'label'=> $label,
                'prop'=> $prop
            ];
            $fieldList = [
                'label'=> $label,
                'type'=> 'input',
                'value'=> end($searchModelClass).'['.$prop.']'
            ];

            if ($prop !== $getPrimaryKey){
                $form[$prop] = [
                    'type'=> 'input',
                    'label' => $label
                ];
            }

        }

        $initContent = str_replace([
            '{form}',
            '{order}',
            '{tableColumns}',
            '{fieldList}',
            '{rowKey}',
            '{pathApi}'
        ], [
            json_encode($form,JSON_UNESCAPED_UNICODE),
            json_encode(array_keys($attributeLabels),JSON_UNESCAPED_UNICODE),
            json_encode($tableColumns,JSON_UNESCAPED_UNICODE),
            json_encode($fieldList,JSON_UNESCAPED_UNICODE),
            "'". $getPrimaryKey."'",
            $pathApi
        ], $initContent);


        $files[] = new CodeFile(
            $viewPath . '/init.js',
            $initContent
        );

        $files[] = new CodeFile(
            $viewPath . '/create.vue',
            $this->render('vue/create.vue')
        );

        $files[] = new CodeFile(
            $viewPath . '/index.vue',
            $this->render('vue/index.vue')
        );

        $files[] = new CodeFile(
            $viewPath . '/update.vue',
            $this->render('vue/update.vue')
        );

        return $files;
    }


    /**
     * @return string the controllers ID (without the module ID prefix)
     */
    public function getControllerID(): string
    {
        $pos = strrpos($this->controllerClass, '\\');
        $class = substr(substr($this->controllerClass, $pos + 1), 0, -10);

        return Inflector::camel2id($class, '-', $this->strictInflector);
    }

    public function createInitParams(): array
    {
        return [
            'mm'=>123
        ];
    }

    /**
     * @return string the controllers view a path
     */
    public function getViewPath(): string
    {
        $controllerClass = StringHelper::dirname(ltrim($this->controllerClass, '\\'));
        [,$path] = explode('admin',$controllerClass);
        echo '子路径：'.$path;
        if (empty($this->viewPath) && $path) {
            $viewPath = Yii::getAlias('@addons/' . $this->moduleID . '/views'.$path.'/' . $this->getControllerID());
            FileHelper::mkdirs($viewPath);

            return $viewPath;
        }else if(empty($this->viewPath)){
            $viewPath = Yii::getAlias('@addons/' . $this->moduleID . '/views/' . $this->getControllerID());
            FileHelper::mkdirs($viewPath);
            return $viewPath;
        }

        return Yii::getAlias(str_replace('\\', '/', $this->viewPath));
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        foreach ($this->getColumnNames() as $name) {
            if (!strcasecmp($name, 'name') || !strcasecmp($name, 'title')) {
                return $name;
            }
        }
        /* @var $class \yii\db\ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();

        return $pk[0];
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField(string $attribute): string
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "\$form->field(\$model, '$attribute')->passwordInput()";
            }

            return "\$form->field(\$model, '$attribute')";
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        }

        if ($column->type === 'text') {
            return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
        }

        if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
            $input = 'passwordInput';
        } else {
            $input = 'textInput';
        }

        if (is_array($column->enumValues) && count($column->enumValues) > 0) {
            $dropDownOptions = [];
            foreach ($column->enumValues as $enumValue) {
                $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
            }
            return "\$form->field(\$model, '$attribute')->dropDownList("
                . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)) . ", ['prompt' => ''])";
        }

        if ($column->phpType !== 'string' || $column->size === null) {
            return "\$form->field(\$model, '$attribute')->$input()";
        }

        return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true])";
    }

    /**
     * Generates code for active search field
     * @param string $attribute
     * @return string
     */
    public function generateActiveSearchField(string $attribute): string
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false) {
            return "\$form->field(\$model, '$attribute')";
        }

        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        }

        return "\$form->field(\$model, '$attribute')";
    }

    /**
     * Generates column format
     * @param ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat(ColumnSchema $column): string
    {
        if ($column->phpType === 'boolean') {
            return 'boolean';
        }

        if ($column->type === 'text') {
            return 'ntext';
        }

        if (stripos($column->name, 'time') !== false && $column->phpType === 'integer') {
            return 'datetime';
        }

        if (stripos($column->name, 'email') !== false) {
            return 'email';
        }

        if (preg_match('/(\b|[_-])url(\b|[_-])/i', $column->name)) {
            return 'url';
        }

        return 'text';
    }

    /**
     * Generates validation rules for the search model.
     * @return array the generated validation rules
     */
    public function generateSearchRules(): array
    {
        if (($table = $this->getTableSchema()) === false) {
            return ["[['" . implode("', '", $this->getColumnNames()) . "'], 'safe']"];
        }
        $types = [];
        foreach ($table->columns as $column) {
            switch ($column->type) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                default:
                    $types['safe'][] = $column->name;
                    break;
            }
        }

        $rules = [];
        foreach ($types as $type => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }

        return $rules;
    }


    /**
     * An inline validator that checks if the attribute value refers to a valid namespaced class name.
     * The validator will check if the directory containing the new class file exist or not.
     * @param string $attribute the attribute being validated
     * @param array $params the validation options
     */
    public function validateNewClass($attribute, $params): void
    {
        $class = ltrim($this->$attribute, '\\');
        if (($pos = strrpos($class, '\\')) === false) {
            $this->addError($attribute, "The class name must contain fully qualified namespace name.");
        } else {
            $ns = substr($class, 0, $pos);
            $path = Yii::getAlias('@' . str_replace('\\', '/', $ns), false);
            if ($path === false) {
                $this->addError($attribute, "The class namespace is invalid: $ns");
            } elseif (!is_dir($path)) {
                FileHelper::mkdirs($path);
                // $this->addError($attribute, "请创建该路径: $path");
            }
        }
    }

    /**
     * @return array searchable attributes
     */
    public function getSearchAttributes(): array
    {
        return $this->getColumnNames();
    }

    /**
     * Generates the attribute labels for the search model.
     * @return array the generated attribute labels (name => label)
     */
    public function generateSearchLabels(): array
    {
        /* @var $model Model */
        $model = new $this->modelClass();
        $attributeLabels = $model->attributeLabels();
        $labels = [];
        foreach ($this->getColumnNames() as $name) {
            if (isset($attributeLabels[$name])) {
                $labels[$name] = $attributeLabels[$name];
            } else {
                if (!strcasecmp($name, 'id')) {
                    $labels[$name] = 'ID';
                } else {
                    $label = Inflector::camel2words($name);
                    if (!empty($label) && substr_compare($label, ' id', -3, 3, true) === 0) {
                        $label = substr($label, 0, -3) . ' ID';
                    }
                    $labels[$name] = $label;
                }
            }
        }

        return $labels;
    }

    /**
     * Generates search conditions
     * @return array
     */
    public function generateSearchConditions(): array
    {
        $columns = [];
        if (($table = $this->getTableSchema()) === false) {
            $class = $this->modelClass;
            /* @var $model Model */
            $model = new $class();
            foreach ($model->attributes() as $attribute) {
                $columns[$attribute] = 'unknown';
            }
        } else {
            foreach ($table->columns as $column) {
                $columns[$column->name] = $column->type;
            }
        }

        $likeConditions = [];
        $hashConditions = [];
        foreach ($columns as $column => $type) {
            switch ($type) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $hashConditions[] = "'{$column}' => \$this->{$column},";
                    break;
                default:
                    $likeKeyword = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
                    $likeConditions[] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";
                    break;
            }
        }

        $conditions = [];
        if (!empty($hashConditions)) {
            $conditions[] = "\$query->andFilterWhere([\n"
                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                . "\n" . str_repeat(' ', 8) . "]);\n";
        }
        if (!empty($likeConditions)) {
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
        }

        return $conditions;
    }

    /**
     * Generates URL parameters
     * @return string
     */
    public function generateUrlParams(): string
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if (count($pks) === 1) {
            if (is_subclass_of($class, 'yii\mongodb\ActiveRecord')) {
                return "'id' => (string)\$model->{$pks[0]}";
            }

            return "'id' => \$model->{$pks[0]}";
        }

        $params = [];
        foreach ($pks as $pk) {
            if (is_subclass_of($class, 'yii\mongodb\ActiveRecord')) {
                $params[] = "'$pk' => (string)\$model->$pk";
            } else {
                $params[] = "'$pk' => \$model->$pk";
            }
        }

        return implode(', ', $params);
    }

    /**
     * Generates action parameters
     * @return string
     */
    public function generateActionParams(): string
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if (count($pks) === 1) {
            return '$id';
        }

        return '$' . implode(', $', $pks);
    }

    /**
     * Generates parameter tags for phpdoc
     * @return array parameter tags for phpdoc
     */
    public function generateActionParamComments(): array
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if (($table = $this->getTableSchema()) === false) {
            $params = [];
            foreach ($pks as $pk) {
                $params[] = '@param ' . (strtolower(substr($pk, -2)) === 'id' ? 'integer' : 'string') . ' $' . $pk;
            }

            return $params;
        }
        if (count($pks) === 1) {
            return ['@param ' . $table->columns[$pks[0]]->phpType . ' $id'];
        }

        $params = [];
        foreach ($pks as $pk) {
            $params[] = '@param ' . $table->columns[$pk]->phpType . ' $' . $pk;
        }

        return $params;
    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     * @return bool|TableSchema
     * @throws InvalidConfigException
     */
    public function getTableSchema(): bool|TableSchema
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        if (is_subclass_of($class, 'yii\db\ActiveRecord')) {
            return $class::getTableSchema();
        }

        return false;
    }

    /**
     * @return array model column names
     * @throws InvalidConfigException
     */
    public function getColumnNames(): array
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        if (is_subclass_of($class, 'yii\db\ActiveRecord')) {
            return $class::getTableSchema()->getColumnNames();
        }

        $model = new $class();

        return $model->attributes();
    }

    /**
     * @return string|null driver name of modelClass db connection.
     * In case db is not instance of \yii\db\Connection null will be returned.
     * @since 2.0.6
     */
    protected function getClassDbDriverName(): ?string
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $db = $class::getDb();
        return $db instanceof Connection ? $db->driverName : null;
    }
}
