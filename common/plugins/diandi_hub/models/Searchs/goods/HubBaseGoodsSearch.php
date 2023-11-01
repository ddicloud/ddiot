<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:46:17
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-13 17:30:38
 */

namespace common\plugins\diandi_hub\models\Searchs\goods;

use common\plugins\diandi_hub\models\enums\GoodsStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdGoodsSearch represents the model behind the search form of `common\models\DdGoods`.
 */
class HubBaseGoodsSearch extends HubGoodsBaseGoods
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'bloc_id', 'store_id', 'category_id', 'spec_type', 'deduct_stock_type', 'sales_initial', 'sales_actual', 'goods_sort', 'delivery_id', 'goods_status', 'is_delete', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['goods_name', 'content', 'selling_point'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
   {

        $DdGoods = new HubGoodsBaseGoods();

        $query = $DdGoods->find()->with(['category']);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'goods_id' => $this->goods_id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'category_id' => $this->category_id,
            'spec_type' => $this->spec_type,
            'deduct_stock_type' => $this->deduct_stock_type,
            'sales_initial' => $this->sales_initial,
            'sales_actual' => $this->sales_actual,
            'goods_sort' => $this->goods_sort,
            'delivery_id' => $this->delivery_id,
            'goods_status' => $this->goods_status,
            'is_delete' => $this->is_delete,
            'wxapp_id' => $this->wxapp_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'content', $this->content]);

        $count = $query->count();
        $pageSize =\Yii::$app->request->input('pageSize');
        $page =\Yii::$app->request->input('page');
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->with('addons')
            //     ->createCommand()
            //     ->getRawSql();
            // var_dump($list);
            // die;
            ->asArray()
            ->all();

        foreach ($list as $key => &$value) {
            $value['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $value['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
            if ($value['addons']) {
                $value['addons']['logo'] = ImageHelper::tomedia($value['addons']['logo']);
                $value['addons']['applets'] = ImageHelper::tomedia($value['addons']['applets']);
            }
            $value['goods_status_str'] = GoodsStatus::getLabel($value['goods_status']);
            $value['goods_type'] = GoodsTypeStatus::getLabel($value['goods_type']);
        }

        $provider = new ArrayDataProvider([
            'key' => 'goods_id',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total' => isset($count) ? $count : 0,
            'sort' => [
                'attributes' => [
                    'goods_id',
                    'goods_sort',
                    'sales_actual',
                ],
                'defaultOrder' => [
                    'goods_id' => SORT_DESC,
                    'goods_sort' => SORT_DESC,
                    'sales_actual' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        return $provider;
    }
}
