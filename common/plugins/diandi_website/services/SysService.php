<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-23 09:19:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-01 14:16:31
 */

namespace common\plugins\diandi_website\services;

use addons\diandi_website\models\enums\AdType;
use addons\diandi_website\models\Nav;
use addons\diandi_website\models\searchs\SysFunCateSearch;
use addons\diandi_website\models\searchs\SysWorthSearch;
use addons\diandi_website\models\searchs\WebsiteAd;
use addons\diandi_website\models\searchs\WebsiteContact;
use addons\diandi_website\models\searchs\WebsiteLink;
use addons\diandi_website\models\searchs\WebsitePage;
use addons\diandi_website\models\searchs\WebsiteSlide;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

class SysService extends BaseService
{
    use \addons\diandi_website\components\ResultServicesTrait;

    public static function getBase()
    {
        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];

        $detail = WebsiteContact::find()->where($where)->asArray()->one();
        $detail['logo'] = ImageHelper::tomedia($detail['logo']);
        $detail['image'] = ImageHelper::tomedia($detail['image']);
        $detail['wechat_code'] = ImageHelper::tomedia($detail['wechat_code']);

        return $detail;
    }

    public static function getNave($type)
    {
        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];

        $list = Nav::find()->where(['type' => $type])->andWhere($where)->orderBy('order')->asArray()->all();
        $menu = ArrayHelper::itemsMerge($list, 0, 'id', 'parent', 'child');

        return $menu;
    }

    public static function getSlide($page_id)
    {
        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];
        $where['page_id'] = $page_id;
        if (empty($where['page_id'])) {
            return ResultHelper::json(400, '缺少页面配置id');
        }

        $list = WebsiteSlide::find()->where($where)->orderBy(['displayorder' => SORT_DESC])->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['images'] = ImageHelper::tomedia($value['images']);
        }

        return $list;
    }

    public static function getPage($template)
    {
        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];
        $where['template'] = $template;
        $page = WebsitePage::find()->where($where)->asArray()->one();
        $page['image'] = ImageHelper::tomedia($page['image']);

        return $page;
    }

    public static function getLink()
    {
        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];
        $link = WebsiteLink::find()->where($where)->asArray()->all();
        foreach ($link as $key => &$value) {
            $value['logo'] = ImageHelper::tomedia($value['logo']);
        }

        return $link;
    }

    public static function getAdList($categoryId = 0, $type = 0)
   {
        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];
        if ($categoryId > 0) {
            $where['category_id'] = $categoryId;
        }
        if (isset(AdType::$list[$type])) {
            $where['type'] = $type;
        }
        $query = WebsiteAd::find()->where($where);
        $pageSize =\Yii::$app->request->input('pageSize') ?? 10;
        $page =\Yii::$app->request->input('page');
        $count = $query->count();
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page,
            'pageParam' => 'page',
        ]);

        $list = $query->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        foreach ($list as &$value) {
            $value['created_at'] = date('Y-m-d H:i', $value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i', $value['updated_at']);
        }

        return ResultHelper::json(200, '请求成功', [
            'list' => $list,
            'total' => (int) $count,
            'pageSize' => (int) $pageSize,
            'page' => (int) ($page > 1 ? ($page - 1) : 1),
        ]);
    }

    public static function getFun($pageInfo = [], $where = [])
    {
        self::$images = ['icon'];

        return self::baseList(SysFunCateSearch::find()->with('fun')->andWhere($where), $pageInfo);
    }

    public static function getWorth($pageInfo = [], $where = [])
    {
        self::$images = ['icon'];

        return self::baseList(SysWorthSearch::find()->andWhere($where), $pageInfo);
    }
}
