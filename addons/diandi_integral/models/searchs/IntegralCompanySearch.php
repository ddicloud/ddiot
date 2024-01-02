<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-30 10:37:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 10:59:48
 */


namespace addons\diandi_integral\models\searchs;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use addons\diandi_integral\models\IntegralCompany as IntegralCompanyModel;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


/**
 * IntegralCompany represents the model behind the search form of `addons\diandi_integral\models\IntegralCompany`.
 */
class IntegralCompanySearch extends IntegralCompanyModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'status', 'display_order', 'is_default', 'create_time', 'update_time', 'store_id', 'bloc_id'], 'integer'],
            [['title', 'code', 'mobile', 'link_man'], 'safe'],
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
     * Creates data provider instance with a search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider|false
     */
    public function search(array $params): ArrayDataProvider|bool
   {
        $query = IntegralCompanyModel::find();

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'display_order' => $this->display_order,
            'is_default' => $this->is_default,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'store_id' => $this->store_id,
            'bloc_id' => $this->bloc_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'link_man', $this->link_man]);
        
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
             'totalCount' => $count,
            'total'=> $count,
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
