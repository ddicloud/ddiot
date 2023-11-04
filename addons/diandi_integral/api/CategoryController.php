<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:50:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 14:44:15
 */

namespace addons\diandi_integral\api;

use addons\diandi_integral\models\IntegralCategory;
use api\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class CategoryController.
 */
class CategoryController extends AController
{
    public $modelClass = '\common\models\IntegralCategory';

    protected array $authOptional = ['list'];

    public function actionSearch(): array
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }


    public function actionList(): array
   {
        $bloc_id  =\Yii::$app->request->input('bloc_id',0);
        $store_id =\Yii::$app->request->input('store_id',0);
        $where  = [];
        // $goodsCate = Yii::$App->cache->get('goodsCate'.$bloc_id.'_'.$store_id);
        // if (!empty($goodsCate)) {
        //     return ResultHelper::json(200, '获取缓存成功', ArrayHelper::itemsMerge($goodsCate, 0, 'category_id', 'parent_id', 'child'));
        // }

        // if ($bloc_id) {
        //     $where['bloc_id'] = $bloc_id;
        // }

        // if ($store_id) {
        //     $where['store_id'] = $store_id;
        // }

        $cate = IntegralCategory::find()->where($where)->asArray()->orderBy('sort')->all();
        $cate = ArrayHelper::itemsMerge($cate, 0, 'category_id', 'parent_id', 'children');

        foreach ($cate as &$item) {
            $item['image_id'] = ImageHelper::tomedia($item['image_id']);
        }
        Yii::$app->cache->set('goodsCate', $cate);

        return ResultHelper::json(200, '获取成功', $cate);
    }
}
