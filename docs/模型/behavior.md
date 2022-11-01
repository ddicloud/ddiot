# 行为

## 数据存储行为

```
 \common\behaviors\SaveBehavior
```

## 行为属性

### updatedAttribute

    数据最后更新时间

### createdAttribute 

    数据创建时间

### time_type

    行为时间类型
    
        
```
<?php

namespace addons\diandi_website\models;

use Yii;

class ProductPrice extends \yii\db\ActiveRecord
{
    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'updated_at',
                'createdAttribute' => 'created_at',
                'time_type' => 'datetime'
            ],
        ];
    }

   
}

```