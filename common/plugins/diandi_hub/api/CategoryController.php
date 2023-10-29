<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:50:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-11 22:51:49
 */

namespace common\plugins\diandi_hub\api;

use Yii;
use api\controllers\AController;
use common\plugins\diandi_hub\models\goods\HubCategory;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;

/**
 * Class CategoryController.
 */
class CategoryController extends AController
{
    public $modelClass = '\common\models\DdCategory';
    protected array $authOptional = ['list'];

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    /**
     * @SWG\Get(path="/diandi_hub/category/list",
     *     tags={"商品"},
     *     summary="商品分类",
     *     @SWG\Response(
     *         response = 200,
     *         description = "商品分类",
     *     ),
     * )
     */
    public function actionList()
    {
        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        $goodsCate = Yii::$app->cache->get('goodsCate'.$bloc_id.'_'.$store_id);
        if (!empty($goodsCate)) {
            return ResultHelper::json(200, '获取成功', ArrayHelper::itemsMerge($goodsCate, 0, 'category_id', 'parent_id', 'child'));
        }

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }

        if ($store_id) {
            $where['store_id'] = $store_id;
        }

        $cate = HubCategory::find()->where($where)->asArray()->orderBy('sort')->all();
        foreach ($cate as &$item) {
            $item['image_id'] = ImageHelper::tomedia($item['image_id']);
        }
        Yii::$app->cache->set('goodsCate', $cate);

        return ResultHelper::json(200, '获取成功', ArrayHelper::itemsMerge($cate, 0, 'category_id', 'parent_id', 'child'));
    }
}
