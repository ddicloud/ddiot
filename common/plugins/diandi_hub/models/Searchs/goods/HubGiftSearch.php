<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 23:30:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:12:09
 */
 

namespace common\plugins\diandi_hub\models\Searchs\goods;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\plugins\diandi_hub\models\goods\HubGift as GoodsHubGift;
use common\components\DataProvider\ArrayDataProvider;
use yii\data\Pagination;

/**
 * HubGiftSearch represents the model behind the search form of `common\addons\diandi_hub\models\HubGift`.
 */
class HubGiftSearch extends GoodsHubGift
{
    public $goods_name='';

    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'goods_id', 'level_num', 'create_time', 'update_time'], 'integer'],
            [['gift_price'], 'number'],
            [['thumb', 'images','goods_name', 'content'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        global $_GPC;
        
        $query = GoodsHubGift::find();

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'goods_id' => $this->goods_id,
            'gift_price' => $this->gift_price,
            'level_num' => $this->level_num,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ])->joinWith('goods as g');

        $goods_name = trim($this->goods_name);
        if(!empty($goods_name)){
            $query->where(['like','g.goods_name',$goods_name]);
        }

        $query->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'content', $this->content]);

       
            $count = $query->count();
            $pageSize = $_GPC['pageSize'];
            $page = $_GPC['page'];
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
    
            $dataProvider = new ArrayDataProvider([
                'key' => 'id',
                'allModels' => $list,
                'totalCount' => isset($count) ? $count : 0,
                'total' => isset($count) ? $count : 0,
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
    
            return $dataProvider;
    }
}
