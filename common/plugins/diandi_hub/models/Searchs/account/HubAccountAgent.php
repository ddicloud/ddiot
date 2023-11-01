<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-22 00:56:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-21 23:38:34
 */
 

namespace common\plugins\diandi_hub\models\Searchs\account;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\account\HubAccountAgent as HubAccountAgentModel;
use yii\data\Pagination;


/**
 * HubAccountAgent represents the model behind the search form of `common\addons\diandi_hub\models\account\HubAccountAgent`.
 */
class HubAccountAgent extends HubAccountAgentModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'order_id', 'order_goods_id', 'member_id', 'bloc_id', 'city_mid', 'area_mid', 'provice_mid', 'city_radio', 'area_radio', 'provice_radio', 'goods_id', 'spec_id', 'update_time', 'create_time'], 'integer'],
            [['performance', 'order_price', 'spec_price', 'goods_price'], 'number'],
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
        $query = HubAccountAgentModel::find();

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'order_goods_id' => $this->order_goods_id,
            'member_id' => $this->member_id,
            'bloc_id' => $this->bloc_id,
            'city_mid' => $this->city_mid,
            'area_mid' => $this->area_mid,
            'provice_mid' => $this->provice_mid,
            'city_radio' => $this->city_radio,
            'area_radio' => $this->area_radio,
            'provice_radio' => $this->provice_radio,
            'performance' => $this->performance,
            'goods_id' => $this->goods_id,
            'order_price' => $this->order_price,
            'spec_id' => $this->spec_id,
            'spec_price' => $this->spec_price,
            'goods_price' => $this->goods_price,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);
        
        $count = $query->count();
        $pageSize   = Yii::$app->request->input('pageSize',10);
        $page       = \Yii::$app->request->input('page',1);
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 
            

        $provider = new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total'=> isset($count) ? $count : 0,
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
            ]
        ]);
        
        return $provider;
        
    }
}
