<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-14 16:19:57
 */

namespace common\behaviors;

use admin\models\addons\models\Bloc as ModelsBloc;
use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/**
 * @author Skilly
 */
class SaveBehavior extends Behavior
{
    public string $createdAttribute = 'create_time';

    public string $updatedAttribute = 'update_time';

    public string $adminAttribute = 'admin_id';

    public string $storeAttribute = 'store_id';

    public string $blocAttribute = 'bloc_id';

    public string $blocPAttribute = 'bloc_pid'; //上级公司

    public string $globalBlocAttribute = 'global_bloc_id'; //上级公司

    public array $attributes = [];

    public array $noAttributes = [];

    public bool $is_bloc = false; //是否是集团数据模型

    public string $time_type = 'init'; //默认为init,可以设置为datetime

    public mixed $value = '';

    private array $_map = [];


    public function init(): void
    {

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAttribute, $this->updatedAttribute, $this->blocAttribute, $this->storeAttribute, $this->blocPAttribute, $this->adminAttribute, $this->globalBlocAttribute], //准备数据 在插入之前更新created和updated两个字段
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->updatedAttribute, $this->blocAttribute, $this->storeAttribute, $this->blocPAttribute, $this->adminAttribute] // 在更新之前更新updated字段
            ];
        }

        $bloc_id = Yii::$app->service->commonGlobalsService->getBloc_id();
        $store_id = Yii::$app->service->commonGlobalsService->getStore_id();

        // 后台多级数据传递,控制台不做这个处理
        if (Yii::$app->id !== 'app-console' && Yii::$app->id !==  'install-console') {
            if (!empty(Yii::$app->request->input('blocs'))) {
                $blocs = \Yii::$app->request->input('blocs');
                $bloc_id = $blocs[0];
                $store_id = $blocs[1];
            }
        }


        $blocPid = ModelsBloc::find()->where(['bloc_id' => $bloc_id])->select('pid')->scalar();

        $admin_id = Yii::$app->user->getIsGuest() ? 0 : Yii::$app->user->identity->id;

        $time = $this->time_type === 'init' ? time() : date('Y-m-d H:i:s', time());

        if ($this->value) {
            $time = $this->value;
        }

        $this->_map = [
            $this->createdAttribute => $time, //在这里你可以随意格式化
            $this->updatedAttribute => $time,
            $this->blocAttribute => (int)$bloc_id,
            $this->storeAttribute => (int)$store_id,
            $this->blocPAttribute => $blocPid ? (int)$blocPid : 0,
            $this->adminAttribute => (int)$admin_id,
            $this->globalBlocAttribute => Yii::$app->params['global_bloc_id'] ?? 0,
        ];
        unset($time, $bloc_id, $store_id, $admin_id, $blocPid, $_GPC);
        // DebugService::consoleWrite('行为-内存测试4');
    }

    //@see http://www.yiichina.com/doc/api/2.0/yii-base-behavior#events()-detail
    public function events(): array
    {
        return array_fill_keys(array_keys($this->attributes), 'evaluateAttributes');
    }


    public function evaluateAttributes($event): void
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = $this->attributes[$event->name];

            foreach ($attributes as $attribute) {
                // 如果赋值了，就不需要改变
                if (!empty($this->owner->attributes[$attribute]) && $attribute == 'store_id') {
                    continue;
                }

                if (!empty($this->owner->attributes[$attribute]) && $attribute == 'bloc_id') {
                    continue;
                }


                if (array_key_exists($attribute, $this->owner->attributes) && !in_array($attribute, $this->noAttributes)) {
                    $this->owner->$attribute = $this->getValue($attribute);
                }
            }
        }
    }

    protected function getValue($attribute)
    {
        return $this->_map[$attribute];
    }

    /**
     * 声明一个析构方法.
     */
    public function __destruct()
    {
        unset($_GPC, $this->_map, $this->attributes, $this->owner);
    }
}
