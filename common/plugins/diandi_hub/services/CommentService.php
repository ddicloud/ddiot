<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 04:22:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-11 22:49:50
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\DdShopComment;
use Yii;
use common\services\BaseService;
use common\helpers\ImageHelper;
use yii\data\Pagination;

/**
 * Class SmsService.
 *
 * @author chunchun <2192138785@qq.com>
 */
class CommentService extends BaseService
{
    public static function list($pageSize)
    {
        $where['status'] = 1; 
        
        // $page = Yii::$App->request->get('page');
        if(Yii::$app->params['bloc_id']){
           $where['bloc_id'] = Yii::$app->params['bloc_id']; 
        }

        if(Yii::$app->params['store_id']){
            $where['store_id'] = Yii::$app->params['store_id']; 
        }
        
        // 创建一个 DB 查询来获得所有
        $query = DdShopComment::find()->where($where)->with(['user', 'fans']);
        // 得到文章的总数（但是还没有从数据库取数据）
        $count = $query->count();
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
        ]);
        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        foreach ($list as $key => &$value) {
            $value['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            if (!empty($value['images'])) {
                $images = unserialize($value['images']);
                $value['images'] = ImageHelper::tomedia($images);
            } else {
                $value['images'] = [];
            }
        }

        return $list;
    }
}
