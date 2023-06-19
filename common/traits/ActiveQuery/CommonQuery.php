<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 15:01:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 11:07:24
 */

namespace common\traits\ActiveQuery;

use common\models\UserStore;
use diandi\addons\models\UserBloc;
use Yii;
use yii\db\ActiveQuery;

class CommonQuery extends ActiveQuery
{
    public $bloc_id;

    public $store_id;
    

    public function init()
    {
        global $_GPC;
        parent::init();
        $this->bloc_id = $_GPC['bloc_id'];
        $this->store_id = $_GPC['store_id'];
    }

    public function findBloc($alias='')
    {
        $this->andWhere([($alias?$alias.'.':'').'bloc_id' => $this->bloc_id]);

        return $this;
    }

    public function findStore($alias='')
    {
        $this->andWhere([($alias?$alias.'.':'').'store_id' => $this->store_id, ($alias?$alias.'.':'').'bloc_id' => $this->bloc_id]);

        return $this;
    }

    /**
     * 根据用户授权进行检索
     * @return void
     * @date 2023-03-03
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function findBlocs($alias='')
    {
        $bloc_ids = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id])->select('bloc_id')->column();
        
        $this->andWhere([($alias?$alias.'.':'').'bloc_id' => $bloc_ids]);

        return $this;
    }

   
    /**
     * 根据用户授权的商户进行检索
     * @return void
     * @date 2023-03-03
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function findStores($alias='')
    {
        $bloc_ids = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id])->select('bloc_id')->column();
        
        $store_ids = UserStore::find()->where(['user_id' => Yii::$app->user->identity->user_id])->select('store_id')->column();
        
        $this->andWhere([($alias?$alias.'.':'').'store_id' => $store_ids, ($alias?$alias.'.':'').'bloc_id' => $bloc_ids]);

        return $this;
    }
}
