<?php

namespace help\controllers;


use yii\gii\controllers\DefaultController;
use yii\web\Response;

class SiteController extends DefaultController
{
    /**
     * Displays homepage.
     *
     * @return Response|string
     */
    public function actionIndex(): Response|string
    {
       return $this->redirect(['/gii']);
    }


}
