<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-06 23:57:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 15:18:17
 */
 

namespace common\plugins\diandi_hub\models\Searchs\express;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\express\HubExpressTemplate as HubExpressTemplateModel;
use yii\data\Pagination;


/**
 * HubExpressTemplate represents the model behind the search form of `common\addons\diandi_hub\models\express\HubExpressTemplate`.
 */
class HubExpressTemplate extends HubExpressTemplateModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'express_id', 'bynum_snum', 'bynum_sprice', 'bynum_xnum', 'bynum_xprice', 'bynum_is_use', 'weight_snum', 'weight_sprice', 'weight_xnum', 'weight_xprice', 'weight_is_use', 'volume_snum', 'volume_sprice', 'volume_xnum', 'volume_xprice', 'volume_is_use', 'create_time', 'update_time'], 'integer'],
            [['title'], 'safe'],
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
        $query = HubExpressTemplateModel::find()->with(['express']);

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'express_id' => $this->express_id,
            'bynum_snum' => $this->bynum_snum,
            'bynum_sprice' => $this->bynum_sprice,
            'bynum_xnum' => $this->bynum_xnum,
            'bynum_xprice' => $this->bynum_xprice,
            'bynum_is_use' => $this->bynum_is_use,
            'weight_snum' => $this->weight_snum,
            'weight_sprice' => $this->weight_sprice,
            'weight_xnum' => $this->weight_xnum,
            'weight_xprice' => $this->weight_xprice,
            'weight_is_use' => $this->weight_is_use,
            'volume_snum' => $this->volume_snum,
            'volume_sprice' => $this->volume_sprice,
            'volume_xnum' => $this->volume_xnum,
            'volume_xprice' => $this->volume_xprice,
            'volume_is_use' => $this->volume_is_use,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        
        $count = $query->count();
        $pageSize   = $_GPC['pageSize'];
        $page       = $_GPC['page'];
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
