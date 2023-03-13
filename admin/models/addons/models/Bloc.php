<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-02 17:55:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-13 15:20:02
 */


namespace admin\models\addons\models;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\HashidsHelper;
use diandi\addons\models\Bloc as BlocModel;
use yii\data\Pagination;


/**
 * Bloc represents the model behind the search form of `diandi\addons\models\Bloc`.
 */
class Bloc extends BlocModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'pid', 'group_bloc_id', 'register_level', 'avg_price', 'status', 'is_group', 'store_id', 'level_num'], 'integer'],
            [['business_name', 'category', 'province', 'city', 'district', 'address', 'longitude', 'latitude', 'telephone', 'recommend', 'special', 'introduction', 'open_time', 'sosomap_poi_uid', 'license_no','invitation_code', 'license_name', 'other_files', 'extra'], 'safe'],
        ];
    }

        /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            empty($this->invitation_code) && Bloc::updateAll(['invitation_code' => HashidsHelper::encode($this->bloc_id)], ['bloc_id' => $this->bloc_id]);
        }
        parent::afterSave($insert, $changedAttributes);
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

        $query = BlocModel::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pid' => $this->pid,
            // 'group_bloc_id' => $this->group_bloc_id,
            'register_level' => $this->register_level,
            'avg_price' => $this->avg_price,
            'status' => $this->status,
            'store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'business_name', $this->business_name])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'recommend', $this->recommend])
            ->andFilterWhere(['like', 'special', $this->special])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'open_time', $this->open_time])
            ->andFilterWhere(['like', 'sosomap_poi_uid', $this->sosomap_poi_uid])
            ->andFilterWhere(['like', 'license_no', $this->license_no])
            ->andFilterWhere(['like', 'license_name', $this->license_name])
            ->andFilterWhere(['like', 'other_files', $this->other_files]);

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
            // ->limit($pagination->limit)
            ->asArray()
            ->all();
        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 


        $provider = new ArrayDataProvider([
            'key' => 'bloc_id',
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
            'pagination' => false
        ]);

        return $provider;
    }
}
