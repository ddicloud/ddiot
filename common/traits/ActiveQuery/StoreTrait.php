<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 13:47:23
 */

namespace common\traits\ActiveQuery;

use Yii;

trait StoreTrait
{
    public array $blocs = [];

    /**
     * find查询扩展.
     *
     * @return CommonQuery
     * @date 2023-06-19
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function find(): CommonQuery
    {
        return new CommonQuery(get_called_class());
    }

    public function fields(): array
    {
        $fields = parent::fields();
        $fields['blocs'] = 'blocs';
        return $fields;
    }

    public function beforeSave($insert): bool
    {
        $blocs = Yii::$app->request->input('blocs');
        if (is_array($blocs) && count($blocs) === 2){
            $this->bloc_id = $blocs[0];
            $this->store_id = $blocs[1];
        }
        return parent::beforeSave($insert);
    }

    public function afterFind(): void
    {
        $store_id = $this->getAttribute('store_id');
        $bloc_id = $this->getAttribute('bloc_id');
        $this->blocs = [$bloc_id,$store_id];
        parent::afterFind();
    }
}
