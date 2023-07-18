<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-10-27 14:37:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-21 23:39:52
 */


namespace common\models\searchs;

use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DdArticle;
use yii\data\Pagination;

/**
 * DdArticleSearch represents the model behind the search form of `common\models\DdArticle`.
 */
class DdArticleSearch extends DdArticle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ishot', 'pcate', 'ccate', 'incontent', 'displayorder', 'createtime', 'edittime', 'click'], 'integer'],
            [['template', 'title', 'description', 'content', 'thumb', 'source', 'author', 'linkurl', 'type', 'credit'], 'safe'],
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
        
        $query = DdArticle::find();



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ishot' => $this->ishot,
            'pcate' => $this->pcate,
            'ccate' => $this->ccate,
            'incontent' => $this->incontent,
            'displayorder' => $this->displayorder,
            'createtime' => $this->createtime,
            'edittime' => $this->edittime,
            'click' => $this->click,
        ]);

        $query->andFilterWhere(['like', 'template', $this->template])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'credit', $this->credit]);

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

        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 


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
    }
}
