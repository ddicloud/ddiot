<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:18:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-13 17:59:08
 */
 

namespace common\models\searchs;

use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DdWebsiteSlide;
use yii\data\Pagination;


/**
 * DdWebsiteSlideSearch represents the model behind the search form of `common\models\DdWebsiteSlide`.
 */
class DdWebsiteSlideSearch extends DdWebsiteSlide
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['images', 'title', 'description', 'menuname', 'menuurl', 'createtime', 'updatetime'], 'safe'],
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

        $query = DdWebsiteSlide::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        

        $query->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'menuname', $this->menuname])
            ->andFilterWhere(['like', 'menuurl', $this->menuurl]);

            
        $count = $query->count();
        $pageSize   = $_GPC['pageSize']??10;
        $page       = $_GPC['page']??1;
        
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

        foreach ($list as $key => &$value) {
            
           $value['images'] = ImageHelper::tomedia($value['images']);

           $value['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
           $value['updatetime'] = date('Y-m-d H:i:s',$value['updatetime']);
        } 


        $provider = new ArrayDataProvider([
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
            ]
        ]);

        return $provider;
            
        return $dataProvider;
    }
}
