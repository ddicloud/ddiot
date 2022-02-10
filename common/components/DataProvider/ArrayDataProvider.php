<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 16:21:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-02 17:23:27
 */
 
namespace common\components\DataProvider;

use Yii;
use yii\base\Component;

class ArrayDataProvider extends \yii\data\ArrayDataProvider
{
    public $total;
    
    /*
     *  @inheritdoc
     */
    protected function prepareModels()
    {
        if (($models = $this->allModels) === null) {
            return [];
        }

        if (($sort = $this->getSort()) !== false) {
            $models = $this->sortModels($models, $sort);
        }

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
        }

        return $models;
    }

    /*
     *       @inheritdoc
     */
    protected function prepareTotalCount()
    {
        return $this->getTotalCount();
    }

}
