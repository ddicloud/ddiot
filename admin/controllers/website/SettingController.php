<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 23:43:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-14 19:51:52
 */

namespace admin\controllers\website;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class SiteController.
 */
class SettingController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['info'];

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'website' => [
                'class' => \yii2mod\settings\actions\SettingsAction::class,
                'view' => 'website',
                'successMessage' => '保存成功',
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \common\models\forms\Website::class,
            ],
        ];
    }

    public function actionConfig()
    {
        global $_GPC;
        $settings = Yii::$app->settings;
        foreach ($_GPC['Website'] as $key => $value) {
            $settings->set('Website', $key , $value);            
        } 

        $info = $settings->getAllBySection('Website');

        return ResultHelper::json(200,'设置成功',$info);

    }

    public function actionInfo()
    {           
        $settings = Yii::$app->settings;
        $settings->invalidateCache(); 
        $info = $settings->getAllBySection('Website');
        return ResultHelper::json(200,'获取成功',$info);
    }
}
