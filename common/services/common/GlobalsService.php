<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:34:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-03 16:35:59
 */

namespace common\services\common;

use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\models\enums\MessageStatus;
use common\models\MessageNoticeLog;
use common\models\UserBloc;
use common\services\BaseService;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocLevel;
use diandi\addons\models\BlocStore;
use diandi\addons\models\form\App;
use diandi\addons\models\form\Baidu;
use diandi\addons\models\form\Email;
use diandi\addons\models\form\Microapp;
use diandi\addons\models\form\Oss;
use diandi\addons\models\form\Sms;
use diandi\addons\models\form\Wechat;
use diandi\addons\models\form\Wechatpay;
use diandi\addons\models\form\Wxapp;
use diandi\admin\models\AuthAssignmentGroup;
use Yii;

/**
 * 全局服务
 *
 * @author chunchun <2192138785@qq.com>
 */
class GlobalsService extends BaseService
{
    // 公司id
    private $bloc_id = 1;

    // 子公司id
    private $store_id = 1;

    // 集团id
    private $global_bloc_id = 1;

    // 集团主营商户
    private $global_store_id = 1;

    //模块标识
    private $addons = 'system';

    public function initId($bloc_id, $store_id, $addons)
    {
        $this->setbloc_id($bloc_id);
        $this->setStore_id($store_id);
        $this->setAddons($addons);
    }

    // 全局设置商家id
    public function setbloc_id($id)
    {
        $this->bloc_id = $id;
    }

    // 全局集团配置参数
    public function getGlobalBloc()
    {
        $Bloc = new Bloc();
        $global_bloc = $Bloc->find()->alias('b')->where(['b.bloc_id' => $this->bloc_id])->select(['global.bloc_id', 'global.store_id'])->innerJoinWith('global')->asArray()->one();

        if (!empty($global_bloc)) {
            // 获取集团数据
            $this->global_bloc_id = $global_bloc['bloc_id'];

            $this->global_store_id = $global_bloc['store_id'];

            Yii::$app->params['global_bloc_id'] = $global_bloc['bloc_id'];

            Yii::$app->params['global_store_id'] = $global_bloc['store_id'];

            return $this->global_bloc_id;
        } else {
            return 0;
        }
    }

    // 获取所有的集团
    public function getGlobalBlocs()
    {
        $Bloc = new Bloc();

        $where['group_bloc_id'] = $this->global_bloc_id;

        $key = ['GlobalBlocs', $this->global_bloc_id, $this->bloc_id];

        $Res = Yii::$app->cache->get($key);
        if (!empty($Res)) {
            return $Res;
        }

        // 获取当前集团所有的公司
        $list = Bloc::find()->where($where)->select(['bloc_id as value', 'business_name as label', 'pid', 'bloc_id'])->asArray()->all();

        $lists = ArrayHelper::itemsMerge($list, 0, 'bloc_id', 'pid', 'children');

        $childs = $this->getChildBlocs($lists, $this->bloc_id);

        $bloc_ids = [];

        $this->getChildFamilyIds($childs, $bloc_ids);

        $Res = [
            'list' => $childs,
            'bloc_ids' => $bloc_ids,
        ];

        Yii::$app->cache->set($key, $Res);

        return $Res;
    }

    public function getChildBlocs($lists, $bloc_id, &$arr = [])
    {
        foreach ($lists as $key => $value) {
            if ($value['bloc_id'] == $bloc_id) {
                $arr = $value['children'];
            } elseif (!empty($value['children']) && $value['bloc_id'] != $bloc_id) {
                $this->getChildBlocs($value['children'], $bloc_id, $arr);
            }
        }

        return $arr;
    }

    // 获取我所有的子集
    public function getChildFamilyIds($children, &$bloc_ids = [])
    {
        if (!empty($children)) {
            foreach ($children as $key => $value) {
                $bloc_ids[] = $value['bloc_id'];
                if (!empty($value['children'])) {
                    $this->getChildFamilyIds($value['children'], $bloc_ids);
                }
            }
        }
    }

    // 全局设置商家id
    public function getbloc_id()
    {

        $key = 'common.globalBloc';

        $globalBloc = Yii::$app->cache->get($key);
        if (isset($globalBloc['bloc_id']) && !empty($globalBloc['bloc_id']) && Yii::$app->id == 'app-backend') {
            return $globalBloc['bloc_id'];
        }

        return $this->bloc_id;
    }

    // 全局设置子公司id
    public function setStore_id($id)
    {
        $this->store_id = $id;
    }

    // 全局获取子公司id
    public function getStore_id()
    {
        $key = 'common.globalBloc';

        $globalBloc = Yii::$app->cache->get($key);
        if (isset($globalBloc['store_id']) && !empty($globalBloc['store_id']) && Yii::$app->id == 'app-backend') {
            return $globalBloc['store_id'];
        }

        return $this->store_id;
    }

    // 全局设置扩展
    public function setAddons($id)
    {
        $this->addons = $id;
    }

    // 全局获取扩展
    public function getAddons()
    {
        return $this->addons;
    }

    public function getBlocAll()
    {
        return Bloc::find()->where(['status' => 1])->asArray()->all();
    }

    /**
     * 获取全局配置信息.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getConf($bloc_id = 0)
    {

        $cacheKey = 'common.conf_' . $bloc_id;
        if (Yii::$app->cache->get($cacheKey)) {
            Yii::$app->params['conf'] = Yii::$app->cache->get($cacheKey);
            return Yii::$app->cache->get($cacheKey);
        }

        // 配置优先级 自己--》集团--》系统默认

        $is_showall = [
            'is_showall' => true,
        ];

        $WechatpayConf = new Wechatpay($is_showall);
        $EmailConf = new Email($is_showall);
        $WxappConf = new Wxapp($is_showall);
        $SmsConf = new Sms($is_showall);
        $BaiduConf = new Baidu($is_showall);
        $WechatConf = new Wechat($is_showall);
        $AppConf = new App($is_showall);
        $MicroappConf = new Microapp($is_showall);
        $OssConf = new Oss($is_showall);

        if (!empty($bloc_id)) {
            // 微信支付配置
            $WechatpayConf->getConf($bloc_id);
            $conf['wechatpay'] = $WechatpayConf;
            // 邮件配置
            $EmailConf->getConf($bloc_id);
            $conf['email'] = $EmailConf;
            // 小程序配置
            $WxappConf->getConf($bloc_id);
            $conf['wxapp'] = $WxappConf;
            // 短信配置
            $SmsConf->getConf($bloc_id);
            $conf['sms'] = $SmsConf;
            // 百度ai-sdk
            $BaiduConf->getConf($bloc_id);
            $conf['baidu'] = $BaiduConf;
            // 公众号配置
            $WechatConf->getConf($bloc_id);
            $conf['wechat'] = $WechatConf;
            // app配置
            $AppConf->getConf($bloc_id);
            $conf['app'] = $AppConf;
            // 抖音小程序
            $MicroappConf->getConf($bloc_id);
            $conf['microapp'] = $MicroappConf;
            // oss配置
            $OssConf->getConf($bloc_id);
            $conf['oss'] = $OssConf;
        }

        // 自己配置为空获取集团
        $Bloc = new Bloc();
        $global_bloc = $Bloc->find()->where(['status' => 1, 'bloc_id' => $bloc_id])->select(['bloc_id', 'store_id'])->one();

        if (!empty($global_bloc)) {
            $global_bloc_id = $global_bloc['group_bloc_id'];

            Yii::$app->params['global_bloc_id'] = $global_bloc['group_bloc_id'];

            Yii::$app->params['global_store_id'] = $Bloc->find()->where(['status' => 1, 'bloc_id' => $global_bloc_id])->select('store_id')->scalar();

            if (empty($conf['baidu'])) {
                // 百度ai-sdk
                $conf['baidu'] = $BaiduConf->getConf($global_bloc_id);
            }

            if (empty($conf['wechatpay'])) {
                // 微信支付配置
                $conf['wechatpay'] = $WechatpayConf->getConf($global_bloc_id);
            }

            if (empty($conf['sms'])) {
                // 短信配置
                $SmsConf->getConf($global_bloc_id);
                $conf['sms'] = $SmsConf;
            }

            if (empty($conf['wxapp'])) {
                // 小程序配置
                $WxappConf->getConf($global_bloc_id);
                $conf['wxapp'] = $WxappConf;
            }

            if (empty($conf['wechat'])) {
                // 公众号配置
                $WechatConf->getConf($global_bloc_id);
                $conf['wechat'] = $WechatConf;
            }

            if (empty($conf['email'])) {
                // 邮件配置
                $EmailConf->getConf($global_bloc_id);
                $conf['email'] = $EmailConf;
            }

            if (empty($conf['app'])) {
                // 邮件配置
                $AppConf->getConf($global_bloc_id);
                $conf['app'] = $AppConf;
            }

            if (empty($conf['microapp'])) {
                // 抖音小程序配置
                $MicroappConf->getConf($global_bloc_id);
                $conf['microapp'] = $MicroappConf;
            }

            if (empty($conf['oss'])) {
                // oss配置
                $OssConf->getConf($global_bloc_id);
                $conf['oss'] = $OssConf;
            }
        }

        // 都为空就使用系统默认的
        if (empty($conf['baidu'])) {
            $conf['baidu'] = Yii::$app->settings->getAllBySection('Baidu');
        }

        if (empty($conf['wechatpay'])) {
            $conf['wechatpay'] = Yii::$app->settings->getAllBySection('Wechatpay');
        }

        if (empty($conf['sms'])) {
            $conf['sms'] = Yii::$app->settings->getAllBySection('Sms');
        }

        if (empty($conf['wxapp'])) {
            $conf['wxapp'] = Yii::$app->settings->getAllBySection('Wxapp');
        }

        if (empty($conf['wechat'])) {
            $conf['wechat'] = Yii::$app->settings->getAllBySection('Wechat');
        }

        if (empty($conf['email'])) {
            $conf['email'] = Yii::$app->settings->getAllBySection('Email');
        }

        if (empty($conf['app'])) {
            // app
            $conf['app'] = Yii::$app->settings->getAllBySection('App');
        }

        if (empty($conf['microapp'])) {
            // 抖音
            $conf['microapp'] = Yii::$app->settings->getAllBySection('Microapp');
        }

        if (empty($conf['oss'])) {
            // 抖音
            $conf['oss'] = Yii::$app->settings->getAllBySection('Oss');
        }

        Yii::$app->cache->set($cacheKey, $conf);

        Yii::$app->params['conf'] = $conf;

        return $conf;
    }

    public function isSelf()
    {
        $store_id = $this->store_id;

        return $store_id == Yii::$app->settings->get('Website', 'store_id');
    }

    /**
     * 获取一个用户所有得公司.
     */
    public function getBlocByuserId($user_id)
    {
        $Bloc = new Bloc();
        $key = ['common', $user_id . '_blocs'];
        if (Yii::$app->cache->get($key)) {
            Yii::$app->params['userBloc'] = Yii::$app->cache->get($key);

            return Yii::$app->cache->get($key);
        }

        $group = AuthAssignmentGroup::findAll(['user_id' => $user_id]);
        $where = [];
        $list = [];
        Yii::$app->params['userBloc'] = [];
        if (!in_array('总管理员', array_column($group, 'item_name'))) {
            $where = ['user_id' => $user_id];
            $UserBloc = new UserBloc();
            $bloc_ids = $UserBloc->find()->where($where)->with(['bloc', 'store'])->select(['bloc_id', 'store_id'])->asArray()->all();
            foreach ($bloc_ids as $key => $value) {
                $value['bloc']['store'][] = $value['store'];
                $list[$value['bloc_id']] = $value['bloc'];
            }
            Yii::$app->params['userBloc'] = array_values($list);
        } else {
            $list = $Bloc->find()
                ->with(['store'])
                ->asArray()
                ->all();
            Yii::$app->params['userBloc'] = $list;
        }

        Yii::$app->cache->set($key, $list);

        return $list;
    }

    /**
     * 获取公司与商户详细信息.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getStoreDetail($store_id)
    {
        $key = 'common.StoreDetail_' . intval($store_id);
        if (Yii::$app->cache->get($key)) {
            return Yii::$app->cache->get($key);
        } else {
            $BlocStore = new BlocStore();
            $store = $BlocStore->find()->where(['store_id' => $store_id])->with(['bloc'])->asArray()->one();
            $info = [];
            if ($store) {
                $store['logopath'] = yii::getAlias('@attachment/' . $store['logo']);
                $store['logo'] = ImageHelper::tomedia($store['logo']);
                $extra = unserialize($store['extra']);
                $extra = is_array($extra) ? $extra : [];
                $info = array_merge($store, $extra);
            }

            $info['isself'] = $this->isSelf();

            Yii::$app->cache->set($key, $info);

            return $info;
        }
    }

    // 获取一个公司的所有子公司
    public function getBlocChild($bloc_id)
    {
        return Bloc::find()->where(['pid' => $bloc_id])->asArray()->all();
    }

    public function getBlocLevel()
    {
        $global_bloc_id = $this->global_bloc_id;

        $key = ['common.getBlocLevel', $global_bloc_id];

        if (!empty(Yii::$app->cache->get($key))) {
            return Yii::$app->cache->get($key);
        }

        $list = BlocLevel::find()->where(['global_bloc_id' => $global_bloc_id])->asArray()->all();
        Yii::$app->cache->set($key, $list);

        return $list;
    }

    /**
     * 获取全局系统消息.
     */
    public function getMessage($bloc_id = 0)
    {
        $cacheKey = 'common.message_' . $bloc_id;
        if (Yii::$app->cache->get($cacheKey)) {
            Yii::$app->params['message'] = Yii::$app->cache->get($cacheKey);

            return;
        }

        $MessageNoticeLog = new MessageNoticeLog();
        $list = $MessageNoticeLog->find()->asArray()->all();
        $status = MessageStatus::listData();
        foreach ($list as $key => &$value) {
            $value['type'] = $status[$value['type']];
        }

        $message = [
            'list' => $list,
            'total' => count($list),
        ];

        Yii::$app->cache->set($cacheKey, $message);

        return $message;
    }
}
