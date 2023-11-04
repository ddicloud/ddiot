<?php

use yii\db\Migration;

class m231104_123105_qrcode extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%qrcode}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(10) unsigned NOT NULL",
            'bloc_id' => "int(11) NULL",
            'member_id' => "int(11) NULL",
            'type' => "varchar(10) NOT NULL",
            'extra' => "int(10) unsigned NOT NULL",
            'qrcid' => "bigint(20) NOT NULL",
            'scene_str' => "varchar(64) NOT NULL",
            'name' => "varchar(50) NOT NULL",
            'keyword' => "varchar(100) NOT NULL",
            'model' => "tinyint(1) unsigned NOT NULL",
            'ticket' => "varchar(250) NOT NULL",
            'url' => "varchar(256) NOT NULL",
            'expire' => "int(10) unsigned NOT NULL",
            'subnum' => "int(10) unsigned NOT NULL",
            'update_time' => "int(10) NULL",
            'create_time' => "int(10) unsigned NOT NULL",
            'status' => "tinyint(1) unsigned NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('idx_qrcid','{{%qrcode}}','qrcid',0);
        $this->createIndex('uniacid','{{%qrcode}}','store_id',0);
        $this->createIndex('ticket','{{%qrcode}}','ticket',0);
        
        
        /* 表数据 */
        $this->insert('{{%qrcode}}',['id'=>'1','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605701102','create_time'=>'1605701102','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'2','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605701385','create_time'=>'1605701385','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'3','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'19','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQFb8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAybTVFeFpBM2JlQkUxMDAwMDAwN1oAAgROD7VfAwQAAAAA','url'=>'http://weixin.qq.com/q/02m5ExZA3beBE10000007Z','expire'=>'0','subnum'=>'0','update_time'=>'1605701454','create_time'=>'1605701454','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'4','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'19','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQFb8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAybTVFeFpBM2JlQkUxMDAwMDAwN1oAAgROD7VfAwQAAAAA','url'=>'http://weixin.qq.com/q/02m5ExZA3beBE10000007Z','expire'=>'0','subnum'=>'0','update_time'=>'1605701526','create_time'=>'1605701526','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'5','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'31','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQFk8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyWWszN1pnM2JlQkUxMDAwMGcwN2MAAgQPELVfAwQAAAAA','url'=>'http://weixin.qq.com/q/02Yk37Zg3beBE10000g07c','expire'=>'0','subnum'=>'0','update_time'=>'1605701647','create_time'=>'1605701647','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'6','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'18','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQG08TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyMUtRZ1luM2JlQkUxMDAwME0wN28AAgSsJLZfAwQAAAAA','url'=>'http://weixin.qq.com/q/021KQgYn3beBE10000M07o','expire'=>'0','subnum'=>'0','update_time'=>'1605772460','create_time'=>'1605772460','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'7','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605774637','create_time'=>'1605774637','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'8','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'23','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQFR8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyVWhlbVlMM2JlQkUxMDAwMGcwN1kAAgS-N7ZfAwQAAAAA','url'=>'http://weixin.qq.com/q/02UhemYL3beBE10000g07Y','expire'=>'0','subnum'=>'0','update_time'=>'1605777343','create_time'=>'1605777343','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'9','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'18','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQG08TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyMUtRZ1luM2JlQkUxMDAwME0wN28AAgSsJLZfAwQAAAAA','url'=>'http://weixin.qq.com/q/021KQgYn3beBE10000M07o','expire'=>'0','subnum'=>'0','update_time'=>'1605777372','create_time'=>'1605777372','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'10','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'0','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQE58TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyamx5ZVpkM2JlQkUxMDAwMHcwN1UAAgSMOLZfAwQAAAAA','url'=>'http://weixin.qq.com/q/02jlyeZd3beBE10000w07U','expire'=>'0','subnum'=>'0','update_time'=>'1605777548','create_time'=>'1605777548','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'11','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'24','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQFj8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAydVduOFlsM2JlQkUxMDAwMDAwN1IAAgShfrZfAwQAAAAA','url'=>'http://weixin.qq.com/q/02uWn8Yl3beBE10000007R','expire'=>'0','subnum'=>'0','update_time'=>'1605795489','create_time'=>'1605795489','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'12','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605796868','create_time'=>'1605796868','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'13','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605802056','create_time'=>'1605802056','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'14','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605802371','create_time'=>'1605802371','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'15','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605802371','create_time'=>'1605802371','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'16','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'21','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQGJ8jwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZFg3TFpDM2JlQkUxMDAwMHcwN0EAAgSEmrZfAwQAAAAA','url'=>'http://weixin.qq.com/q/02dX7LZC3beBE10000w07A','expire'=>'0','subnum'=>'0','update_time'=>'1605802628','create_time'=>'1605802628','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'17','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605803900','create_time'=>'1605803900','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'18','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605805293','create_time'=>'1605805293','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'19','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605805341','create_time'=>'1605805341','status'=>'0']);
        $this->insert('{{%qrcode}}',['id'=>'20','store_id'=>'48','bloc_id'=>'8','member_id'=>NULL,'type'=>'2','extra'=>'0','qrcid'=>'0','scene_str'=>'22','name'=>'','keyword'=>'','model'=>'0','ticket'=>'gQHL8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZl9GOVlzM2JlQkUxMDAwMGcwN3oAAgSD-rRfAwQAAAAA','url'=>'http://weixin.qq.com/q/02f_F9Ys3beBE10000g07z','expire'=>'0','subnum'=>'0','update_time'=>'1605805341','create_time'=>'1605805341','status'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%qrcode}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

