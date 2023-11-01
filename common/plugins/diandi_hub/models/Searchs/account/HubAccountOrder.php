<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-02 14:23:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-29 16:15:52
 */
 

namespace common\plugins\diandi_hub\models\Searchs\account;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\account\HubAccountOrder as HubAccountOrderModel;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\helpers\StringHelper;
use yii\data\Pagination;


/**
 * HubAccountOrder represents the model behind the search form of `common\addons\diandi_hub\models\account\HubAccountOrder`.
 */
class HubAccountOrder extends HubAccountOrderModel
{
    public $order_no_str = '';
    
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'status', 'memberc_id', 'member_id', 'is_count', 'type', 'order_goods_id', 'order_type', 'goods_type', 'order_id', 'goods_id', 'update_time', 'create_time'], 'integer'],
            [['performance', 'order_price', 'goods_price', 'money'], 'number'],
            [['order_no_str'], 'safe'],
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
        $query = HubAccountOrderModel::find();
 
        $query->with([
            'orderGoods',
            'goodsSpec','goodsSpecRel','goodsShare',
            'memberc','member',
            'levelc','level'
        ]);
        
   
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }


        $whereOrder = [];

        if(!empty($this->order_no_str)){
           
        
            $GorderType = StringHelper::msubstr($this->order_no_str,0,1);
            
            if($GorderType == 'S'){
                // 到店订单
                
                $query->joinWith('storeOrder as order');
                $whereOrder = ['like','order.order_no',$this->order_no_str];
                $query->andFilterWhere($whereOrder);

            }else{

                $query->joinWith('order as order');
                $whereOrder = ['like','order.order_no',$this->order_no_str];
                $query->andFilterWhere($whereOrder);
                // 排除到店订单
                $query->andFilterWhere(['!=','order.order_type',OrderTypeStatus::getValueByName('到店订单')]);
          
            }
           
       
        }
        
        $this->is_count = 0;
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'memberc_id' => $this->memberc_id,
            'member_id' => $this->member_id,
            'is_count' => $this->is_count,
            'type' => $this->type,
            'performance' => $this->performance,
            'order_goods_id' => $this->order_goods_id,
            'order_type' => $this->order_type,
            'goods_type' => $this->goods_type,
            'order_id' => $this->order_id,
            'order_price' => $this->order_price,
            'goods_id' => $this->goods_id,
            'goods_price' => $this->goods_price,
            'money' => $this->money,
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
