<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 15:01:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-20 09:46:15
 */

namespace common\traits\ActiveQuery;

use common\models\UserStore;
use diandi\addons\models\UserBloc;
use Yii;
use yii\db\ActiveQuery;

class CommonQuery extends ActiveQuery
{
    public int $bloc_id;

    public int $store_id;
    

    public function init(): void
   {
        parent::init();
        $this->bloc_id = Yii::$app->request->input('bloc_id',0);
        $this->store_id = Yii::$app->request->input('store_id',0);
    }

    public function findBloc($alias=''): static
    {
        if ($this->where){
            $this->andWhere([($alias?$alias.'.':'').'bloc_id' => $this->bloc_id]);
        }else{
            $this->where([($alias?$alias.'.':'').'bloc_id' => $this->bloc_id]);
        }
        return $this;
    }

    public function findStore($alias=''): static
    {
        if ($this->where){
            $this->andWhere([($alias?$alias.'.':'').'store_id' => $this->store_id, ($alias?$alias.'.':'').'bloc_id' => $this->bloc_id]);
        }else{
            $this->where([($alias?$alias.'.':'').'store_id' => $this->store_id, ($alias?$alias.'.':'').'bloc_id' => $this->bloc_id]);
        }
        return $this;
    }

    /**
     * 根据用户授权进行检索
     * @param string $alias
     * @return CommonQuery
     * @date 2023-03-03
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function findBlocs(string $alias=''): static
    {
        $bloc_ids = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id??0])->select('bloc_id')->column();
        if ($this->where){
            $this->andWhere([($alias?$alias.'.':'').'bloc_id' => $bloc_ids]);
        }else{
            $this->where([($alias?$alias.'.':'').'bloc_id' => $bloc_ids]);
        }
        return $this;
    }


    /**
     * 根据用户授权的商户进行检索
     * @param string $alias
     * @return CommonQuery
     * @date 2023-03-03
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function findStores(string $alias=''): static
    {
        $bloc_ids = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id??0])->select('bloc_id')->column();
        
        $store_ids = UserStore::find()->where(['user_id' => Yii::$app->user->identity->user_id??0])->select('store_id')->column();
        if ($this->where){
            $this->andWhere([($alias?$alias.'.':'').'store_id' => $store_ids, ($alias?$alias.'.':'').'bloc_id' => $bloc_ids]);
        }else{
            $this->where([($alias?$alias.'.':'').'store_id' => $store_ids, ($alias?$alias.'.':'').'bloc_id' => $bloc_ids]);
        }
        return $this;
    }
}
