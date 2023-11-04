<?php

use yii\db\Migration;

class m220613_090925_diandi_tea_hourse extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_hourse}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '包间id'",
            'bloc_id' => "int(11) NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NULL COMMENT '店铺id'",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'name' => "varchar(100) NOT NULL COMMENT '包间名'",
            'picture' => "varchar(255) NULL COMMENT '包间图片'",
            'introduce' => "text NULL COMMENT '包间介绍'",
            'max_num' => "int(11) NULL COMMENT '可容纳人数'",
            'tip' => "text NULL COMMENT '包间说明'",
            'status' => "smallint(6) NULL COMMENT '包间状态：1.空闲中 2.待打扫 3.待客中'",
            'set_meal_ids' => "varchar(100) NULL COMMENT '包间套餐列表'",
            'fit_num' => "varchar(100) NULL COMMENT '包间适合人数'",
            'price' => "decimal(10,2) NULL",
            'slide' => "text NULL COMMENT '包间幻灯片'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='包间表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'5','bloc_id'=>'30','store_id'=>'79','create_time'=>'0000-00-00 00:00:00','update_time'=>'2022-06-13 10:07:14','name'=>'鸿儒堂','picture'=>'202206/12/10f5d094-22b0-36d5-bcc9-f9a0294a6512.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'12','tip'=>'会议房','status'=>'1','set_meal_ids'=>'11,9,7,11,9,7','fit_num'=>'','price'=>'108.00','slide'=>'[\"202206\\/13\\/71cee807-0644-3452-839d-085a0adfd3dd.jpg\",\"202206\\/13\\/a84bd731-13e2-3177-b093-e43dc79db433.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'7','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-17 10:09:35','update_time'=>'2022-06-13 11:12:36','name'=>'闲野舍','picture'=>'202206/12/6702c298-511a-34ca-b82f-1a2481e7d179.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'4','tip'=>'麻将房','status'=>'1','set_meal_ids'=>'3,4,5','fit_num'=>'','price'=>'58.00','slide'=>'[\"202206\\/13\\/bf6afd1c-065a-3000-b112-e7918256bb74.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'8','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 14:15:48','update_time'=>'2022-06-13 11:12:56','name'=>'千帆境','picture'=>'202206/12/cf1063f7-3c53-34e0-8909-b438bae111c6.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'6','tip'=>'商务房','status'=>'1','set_meal_ids'=>'6,8,10','fit_num'=>'','price'=>'88.00','slide'=>'[\"202206\\/13\\/6e14019d-c482-3ba4-a889-3b9b0af555e4.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'9','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 14:47:09','update_time'=>'2022-06-13 11:13:10','name'=>'泊云居','picture'=>'202206/12/64afe217-8338-315e-b432-531295eebfcf.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'6','tip'=>'私密房','status'=>'1','set_meal_ids'=>'6,8,10','fit_num'=>'','price'=>'88.00','slide'=>'[\"202206\\/13\\/46da3c8b-a421-320b-8640-cc7ad19bf377.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'10','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-10 17:46:30','update_time'=>'2022-06-13 11:13:23','name'=>'君弈轩','picture'=>'202206/12/9298ac02-667e-3c45-84d7-64a221c9ce36.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'4','tip'=>'棋牌房','status'=>'1','set_meal_ids'=>'15,13,14','fit_num'=>'','price'=>'68.00','slide'=>'[\"202206\\/13\\/7166f471-1a81-3ddd-8b89-3de1617cf9df.jpg\"]']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_hourse}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

