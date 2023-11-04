<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 03:21:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 00:54:17
 */

namespace addons\diandi_integral\backend\setting;

use diandi\addons\components\StoreController as ComponentsStoreController;

/**
 * StoreController implements the CRUD actions for DdDiandiShopStore model.
 */
class StoreController extends ComponentsStoreController
{
    public string $modelSearchName = 'DdShopCommentSearch';

    public $extras = [
        'sendtime',
        'service',
        'title',
        'intro',
        'address',
        'mobile',
        'des',
        'Lodop_ip',
        'logo',
        'banner',
        'startingPrice',
        'shippingDees',
        'id',
        'distance',
        'lng_lat',
        'notice',
        'surroundings',
        'certificate',
        'shareimg',
        'hotSearch',
        'contact_type',
        'USER',
        'UKEY',
        'SN',
        'printNum',
        'newTitle',
    ];
}
