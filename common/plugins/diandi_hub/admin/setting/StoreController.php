<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 03:21:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-24 09:55:15
 */

namespace common\plugins\diandi_hub\admin\setting;

use admin\controllers\StoreController as ControllersStoreController;

/**
 * StoreController implements the CRUD actions for DdDiandiShopStore model.
 */
class StoreController extends ControllersStoreController
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
        'myshareimg',
        'douradio',
        'moneyradio',
        'hotSearch',
        'contact_type',
        'USER',
        'UKEY',
        'SN',
        'onecode',
        'printNum',
        'newTitle',
        'agemoney',
        'send_type',
        'money_uid',
        'linkman',
        'adthumb',
        'storeRadio',
    ];
}
