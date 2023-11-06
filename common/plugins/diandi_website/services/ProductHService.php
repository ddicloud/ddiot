<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-23 10:46:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-23 15:04:27
 */

namespace common\plugins\diandi_website\services;

use common\services\BaseService;
use addons\diandi_website\models\WebsiteProH5Body;
use addons\diandi_website\models\WebsiteProH5Top;

class ProductHService extends BaseService
{
    use \addons\diandi_website\components\ResultServicesTrait;

    public static function getH5BodyList($pageInfo = [])
    {
        self::$images = ['image_a', 'image_b'];
        return self::baseList(WebsiteProH5Body::find(), $pageInfo);
    }

    public static function getH5BodyView($id)
    {
        self::$images = ['image_a', 'image_b'];
        return self::selectOne(WebsiteProH5Body::find(), ['id' => $id]);
    }
    public static function getH5TopList($pageInfo = [])
    {
        self::$images = ['image', 'logo_a', 'logo_b'];
        return self::baseList(WebsiteProH5Top::find(), $pageInfo);
    }

    public static function getH5TopView($id)
    {
        self::$images = ['image', 'logo_a', 'logo_b'];
        return self::selectOne(WebsiteProH5Top::find(), ['id' => $id]);
    }
}
