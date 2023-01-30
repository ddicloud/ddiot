<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-28 22:31:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-12-21 11:38:04
 */

/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}

echo "<?php\n";
?>

namespace <?= $generator->queryNs ?>;

/**
 * This is the ActiveQuery class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->queryBaseClass, '\\') . "\n" ?>
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return <?= $modelFullClassName ?>[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return <?= $modelFullClassName ?>|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
