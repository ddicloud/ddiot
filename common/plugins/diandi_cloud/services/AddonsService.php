<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 01:42:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-09 15:48:31
 */

namespace common\plugins\diandi_cloud\services;

use common\services\BaseService;
use common\plugins\diandi_cloud\models\CloudAddons;
use common\plugins\diandi_cloud\models\CloudAuthAddons;
use common\plugins\diandi_cloud\models\CloudAuthDomain;
use common\plugins\diandi_cloud\models\CloudAuthUser;
use common\plugins\diandi_cloud\models\enums\AuthUserStatus;
use common\plugins\diandi_cloud\models\enums\AuthDomainStatus;
use common\helpers\loggingHelper;

class AddonsService extends BaseService
{
    use \addons\diandi_cloud\components\ResultServicesTrait;

    public static function initData()
    {
        # code...
    }

    public static function getLists($pageInfo = [], $where = [])
    {
        self::$images = ['logo', 'applets'];
        return self::_baseList(CloudAddons::find()->with('cate')->andWhere($where), $pageInfo);
    }

    public static function getDetail($id)
    {
        self::$images = ['logo', 'applets'];
        return self::selectOne(CloudAddons::find()->with('cate')->andWhere(['id' => $id]));
    }

    /**
     * 验证应用
     * @param string $webKey 系统秘钥
     * @param string $url    域名
     * @param string $addons 应用模块英文标识
     * @return void
     * @date 2022-07-11
     */
    public static function authAddons($webKey, $url, $addons)
    {
        loggingHelper::writeLog('diandi_cloud','authAddons','授权校验记录',['webKey'=>$webKey,'url'=> $url,'addons'=> $addons]);
        // 白名单域名
        if(in_array($url,['https://www.dandicloud.cn'])){
            return true;
        }

        if (!$webKey || !$url || !$addons) {
            return '请检查授权域名，授权模块与授权秘钥的正确性!';
        } else {
            $authUser = CloudAuthUser::find()->andWhere(['web_key' => $webKey, 'status' => AuthUserStatus::STATUS_NORMAL])->one();
            if (!$authUser) {
                return '无效的授权秘钥！';
            }
            $time = date('Y-m-d H:i:s');
            $authDomain = CloudAuthDomain::find()
                ->andWhere(['domin_url' => $url, 'member_id' => $authUser->member_id, 'status' => AuthDomainStatus::STATUS_NORMAL])
                ->andWhere("start_time <= '" . $time . "'")
                ->andWhere("end_time >= '" . $time . "'")
                ->one();
            if (!$authDomain) {
                return '当前授权域名未授权或已失效！';
            }
            $authAddons = CloudAuthAddons::find()
                ->andWhere(['domin_url' => $url, 'member_id' => $authUser->member_id])
                ->andWhere("start_time <= '" . $time . "'")
                ->andWhere("end_time >= '" . $time . "'")
                ->one();
            if (!$authAddons) {
                return '当前授权应用未授权或已失效！';
            }

            return true;
        }
    }

    public static function authDomain($domain)
    {
        if (!$domain) {
            return '请输入需要检测的授权域名【Http://test.com】';
        } else {
            $time = date('Y-m-d H:i:s');
            $authDomain = CloudAuthDomain::find()
                ->andWhere(['domin_url' => $domain, 'status' => AuthDomainStatus::STATUS_NORMAL])
                ->andWhere("start_time <= '" . $time . "'")
                ->andWhere("end_time >= '" . $time . "'")
                ->one();
            if (!$authDomain) {
                return '当前授权域名未授权或已失效！';
            } else {
                return true;
            }
        }
    }
}
