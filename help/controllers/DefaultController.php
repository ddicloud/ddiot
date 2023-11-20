<?php

namespace help\controllers;

use Yii;

class DefaultController extends \yii\gii\controllers\DefaultController
{
    public function actionView($id)
    {
        $generator = $this->loadGenerator($id);
        $params = ['generator' => $generator, 'id' => $id];

        $preview = Yii::$app->request->post('preview');
        $generate = Yii::$app->request->post('generate');
        $answers = Yii::$app->request->post('answers');

        if ($preview !== null || $generate !== null) {
            if ($generator->validate()) {
                $generator->saveStickyAttributes();
                $files = $generator->generate();
                if ($generate !== null && !empty($answers)) {
                    $params['hasError'] = !$generator->save($files, (array)$answers, $results);
                    $params['results'] = $results;
                } else {
                    $params['files'] = $files;
                    $params['answers'] = $answers;
                }
            }
        }
        if (Yii::$app->request->isPost) {
            switch ($id) {
                case 'model':
                    $Generator = Yii::$app->request->getBodyParam('Generator');
                    if ($Generator['tableName'] && empty($Generator['modelClass'])){
                        $tableName =  $Generator['tableName'];
                        $TablePrefix = $generator->getTablePrefix();
                        $tableName = str_replace($TablePrefix, '', $tableName);
                        $tableNameArray = explode('_', $tableName);
                        $modelClass = '';
                        foreach ($tableNameArray as $item) {
                            $modelClass .= ucwords($item);
                        }
                        return $modelClass;
                    }

                    break;
            }

        }
        return $this->render('view', $params);
    }
}