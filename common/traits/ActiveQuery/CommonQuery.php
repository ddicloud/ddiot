<?php

namespace common\traits\ActiveQuery;

use yii\db\ActiveQuery;

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 15:01:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-22 15:01:58
 */
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

    public function findBloc()
    {
        $this->andWhere(['bloc_id' => $this->bloc_id]);

        return $this;
    }

    public function findStore()
    {
        $this->andWhere(['store_id' => $this->store_id]);

        return $this;
    }
}
