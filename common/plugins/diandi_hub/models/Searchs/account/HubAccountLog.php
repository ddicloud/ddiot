<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-12 11:33:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-12 12:32:59
 */
 

namespace common\plugins\diandi_hub\models\Searchs\account;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\account\HubAccountLog as HubAccountLogModel;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\helpers\StringHelper;
use yii\data\Pagination;


/**
 * HubAccountLog represents the model behind the search form of `common\addons\diandi_hub\models\account\HubAccountLog`.
 */
class HubAccountLog extends HubAccountLogModel
{
    
    public $order_no='';
     
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'member_id', 'order_goods_id', 'account_type', 'change_type', 'is_add', 'order_type', 'goods_type', 'order_id', 'goods_id', 'update_time', 'create_time'], 'integer'],
            [['money', 'order_price', 'goods_price', 'performance'], 'number'],
            [['order_no'],'safe']
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
        $query = HubAccountLogModel::find();
        $query->with(['goods','ordergoods','member']);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

      

        $whereOrder = [];
        
        if(!empty($this->order_no)){
           
        
            $GorderType = StringHelper::msubstr($this->order_no,0,1);
            
            if($GorderType == 'S'){
                // 到店订单
                
                $query->joinWith('storeOrder as order');
                $whereOrder = ['like','order.order_no',$this->order_no];
                $query->andFilterWhere($whereOrder);

            }else{

                $query->joinWith('order as order');
                $whereOrder = ['like','order.order_no',$this->order_no];
                $query->andFilterWhere($whereOrder);
                // 排除到店订单
                $query->andFilterWhere(['!=','order.order_type',OrderTypeStatus::getValueByName('到店订单')]);
          
            }
           
       
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'member_id' => $this->member_id,
            'order_goods_id' => $this->order_goods_id,
            'account_type' => $this->account_type,
            'change_type' => $this->change_type,
            'money' => $this->money,
            'is_add' => $this->is_add,
            'order_type' => $this->order_type,
            'goods_type' => $this->goods_type,
            'order_id' => $this->order_id,
            'order_price' => $this->order_price,
            'goods_id' => $this->goods_id,
            'goods_price' => $this->goods_price,
            'performance' => $this->performance,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);
        
        $count = $query->count();
        $pageSize   =\Yii::$app->request->input('pageSize',10);
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
