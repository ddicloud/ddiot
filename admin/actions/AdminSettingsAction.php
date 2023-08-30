<?php
/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-20 16:16:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-20 16:20:24
 */

namespace admin\actions;

use common\helpers\ResultHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii2mod\settings\actions\SettingsAction;
use yii2mod\settings\events\FormEvent;

class AdminSettingsAction extends SettingsAction
{
    /**
     * Renders the settings form.
     *
     * @return array|object[]|string|string[]|\yii\web\Response
     * @throws InvalidConfigException
     */
    public function run(): array|\yii\web\Response|string
    {
        $model = Yii::createObject($this->modelClass);
        $event = Yii::createObject(['class' => FormEvent::class, 'form' => $model]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->trigger(self::EVENT_BEFORE_SAVE, $event);

            $this->saveSettings($model);

            $this->trigger(self::EVENT_AFTER_SAVE, $event);

            if ($this->successMessage !== null) {
                Yii::$app->session->setFlash('success', $this->successMessage);
            }

            return $this->controller->refresh();
        }

        $this->prepareModel($model);

        return ResultHelper::json(200, '设置成功', []);
    }
}
