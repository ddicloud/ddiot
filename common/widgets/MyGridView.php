<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-01 00:48:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-01 00:54:16
 */

namespace common\widgets;
 

use yii\grid\GridView;


class MyGridView extends GridView
{
    
    public $tableOptions = ['class' => 'table  table-bordered'];
    
    public $layout = "{items}\n{pager}";
    
}

