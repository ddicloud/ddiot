<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:46:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 14:18:54
 */

namespace addons\diandi_integral\models\searchs;

use addons\diandi_integral\models\IntegralGoods;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdGoodsSearch represents the model behind the search form of `common\models\IntegralGoods`.
 */
class IntegralGoodsSearch extends IntegralGoods
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id','bloc_id', 'store_id','category_id', 'spec_type', 'deduct_stock_type','goods_integral','sales_initial', 'sales_actual', 'goods_sort', 'delivery_id', 'goods_status', 'is_delete', 'create_time', 'update_time'], 'integer'],
            [['goods_name', 'content'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with a search query applied.
     *
     * @param array $params
     *
     * @return ArrayDataProvider|ActiveDataProvider
     */
    public function search(array $params): ArrayDataProvider|ActiveDataProvider
   {
        $DdGoods = new IntegralGoods();
        
        $query = $DdGoods->find()->with(['category','delivery']);
  
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            //echo 123;die;
            return $dataProvider;
        }

  
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
            ->asArray()
            ->all();


        return new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $list,
            'totalCount' => $count ?? 0,
            'total' => $count ?? 0,
            'sort' => [
                'attributes' => [
                    //'member_id',
                ],
                'defaultOrder' => [
                    //'member_id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
    }
}
