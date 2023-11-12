<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-31 18:11:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-18 09:58:16
 */

/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)) : ?>
    use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else : ?>
    use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use Throwable;

/**
* <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
*/
class <?= $controllerClass ?> extends AController
{
public string $modelSearchName = "<?= $searchModelAlias ?? $searchModelClass ?>";

public $modelClass = '';


/**
* Lists all <?= $modelClass ?> models.
* @return array
*/
public function actionIndex(): array
{
<?php if (!empty($generator->searchModelClass)) : ?>
    $searchModel = new <?= $searchModelAlias ?? $searchModelClass ?>();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return ResultHelper::json(200, '获取成功',[
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'modelSearchName'=>$this->modelSearchName,
    'field' => $searchModel->attributeLabels()
    ]);
<?php else : ?>
    $dataProvider = new ActiveDataProvider([
    'query' => <?= $modelClass ?>::find(),
    ]);

    return ResultHelper::json(200, '获取成功',[
    'dataProvider' => $dataProvider,
    ]);

<?php endif; ?>
}

/**
* Displays a single <?= $modelClass ?> model.
* <?= implode("\n     * ", $actionParamComments) . "\n" ?>
* @return array
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionView(<?= $actionParams ?>): array
{
    $view = $this->findModel(<?= $actionParams ?>);

    return ResultHelper::json(200, '获取成功', $view->toArray());
}

/**
* Creates a new <?= $modelClass ?> model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return array
*/
public function actionCreate(): array
{
    $model = new <?= $modelClass ?>();
    $data = Yii::$app->request->post();
    if ($model->load($data, '') && $model->save()) {
        return ResultHelper::json(200, '创建成功', $model->toArray());
    } else {
        $msg = ErrorsHelper::getModelError($model);
        return ResultHelper::json(400, $msg);
    }
}

/**
* Updates an existing <?= $modelClass ?> model.
* If update is successful, the browser will be redirected to the 'view' page.
* <?= implode("\n     * ", $actionParamComments) . "\n" ?>
* @return array
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate(<?= $actionParams ?>): array
{
    $model = $this->findModel(<?= $actionParams ?>);
    $data = Yii::$app->request->post();
    if ($model->load($data, '') && $model->save()) {
        return ResultHelper::json(200, '编辑成功', $model->toArray());
    } else {
        $msg = ErrorsHelper::getModelError($model);
        return ResultHelper::json(400, $msg);
    }
}

/**
* Deletes an existing WeihExhibitionServiceProvider model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $id
* @return array
* @throws NotFoundHttpException if the model cannot be found
* @throws Throwable
* @throws StaleObjectException
*/
public function actionDelete(<?= $actionParams ?>): array
{
    $this->findModel(<?= $actionParams ?>)->delete();

    return ResultHelper::json(200, '删除成功');
}

/**
* Finds the <?= $modelClass ?> model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* <?= implode("\n     * ", $actionParamComments) . "\n" ?>
* @return array|ActiveRecord the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel(<?= $actionParams ?>): array|ActiveRecord
{
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
return $model;
}

throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
}
}