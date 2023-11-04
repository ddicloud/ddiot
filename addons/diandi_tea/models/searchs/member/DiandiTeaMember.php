<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 14:06:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-15 16:07:45
 */


namespace addons\diandi_tea\models\searchs\member;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use addons\diandi_tea\models\member\DiandiTeaMember as DiandiTeaMemberModel;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


/**
 * DiandiTeaMember represents the model behind the search form of `addons\diandi_tea\models\member\DiandiTeaMember`.
 */
class DiandiTeaMember extends DiandiTeaMemberModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider|false
     */
    public function search(array $params): ArrayDataProvider|bool
   {
        $query = DiandiTeaMemberModel::find();

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);
        
        $count = $query->count();
        $pageSize   =\Yii::$app->request->input('pageSize');
        $page       =\Yii::$app->request->input('page');
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


        return new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => $count ?? 0,
            'total'=> $count ?? 0,
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
        
    }
}
