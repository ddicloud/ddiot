<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-25 15:13:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-25 15:23:08
 */

namespace addons\diandi_tea\models\searchs\config;
use addons\diandi_tea\models\enums\SlideType;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use \addons\diandi_tea\models\config\TeaSlide as TeaSlideModel;

/**
 * TeaSlide represents the model behind the search form of `addons\diandi_tea\models\config\TeaSlide`.
 */
class TeaSlide extends TeaSlideModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'type'], 'integer'],
            [['create_time', 'update_time', 'slide'], 'safe'],
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
     * @return ArrayDataProvider|bool|ActiveDataProvider
     */
    public function search(array $params): ArrayDataProvider|bool|ActiveDataProvider
   {
        $query = TeaSlideModel::find();


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
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'slide', $this->slide]);

        $count = $query->count();
        $pageSize =\Yii::$app->request->input('pageSize');
        $page =\Yii::$app->request->input('page');
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

        $SlideType = SlideType::listData();
        foreach ($list as &$value) {
            $value['slide'] = ImageHelper::tomedia($value['slide']);
            $value['type'] = $SlideType[$value['type']];
        }

        return new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $list,
            'totalCount' => $count ?? 0,
            'total' => $count ?? 0,
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
