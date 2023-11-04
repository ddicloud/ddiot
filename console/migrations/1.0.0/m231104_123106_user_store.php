<?php

use yii\db\Migration;

class m231104_123106_user_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_store}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NULL DEFAULT '0' COMMENT '管理员id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '集团id'",
            'store_id' => "int(11) NULL DEFAULT '0' COMMENT '子公司id'",
            'status' => "int(11) NULL COMMENT '是否启用'",
            'is_default' => "smallint(6) NULL DEFAULT '0' COMMENT '是否默认'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%user_store}}',['id'=>'270','user_id'=>'83','bloc_id'=>'91','store_id'=>'153','status'=>'0','is_default'=>'1','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'179','user_id'=>'11','bloc_id'=>'49','store_id'=>'148','status'=>'0','is_default'=>'0','create_time'=>'1678437959','update_time'=>'1678437959']);
        $this->insert('{{%user_store}}',['id'=>'276','user_id'=>'83','bloc_id'=>'91','store_id'=>'182','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'274','user_id'=>'83','bloc_id'=>'91','store_id'=>'180','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'275','user_id'=>'83','bloc_id'=>'91','store_id'=>'181','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'273','user_id'=>'83','bloc_id'=>'91','store_id'=>'179','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'193','user_id'=>'11','bloc_id'=>'51','store_id'=>'150','status'=>'0','is_default'=>'0','create_time'=>'1678974444','update_time'=>'1678974444']);
        $this->insert('{{%user_store}}',['id'=>'178','user_id'=>'11','bloc_id'=>'38','store_id'=>'137','status'=>'0','is_default'=>'0','create_time'=>'1678437959','update_time'=>'1678437959']);
        $this->insert('{{%user_store}}',['id'=>'192','user_id'=>'11','bloc_id'=>'51','store_id'=>'149','status'=>'0','is_default'=>'0','create_time'=>'1678974444','update_time'=>'1678974444']);
        $this->insert('{{%user_store}}',['id'=>'184','user_id'=>'11','bloc_id'=>'51','store_id'=>'151','status'=>'1','is_default'=>'0','create_time'=>'1678785082','update_time'=>'1678785082']);
        $this->insert('{{%user_store}}',['id'=>'185','user_id'=>'11','bloc_id'=>'51','store_id'=>'152','status'=>'1','is_default'=>'0','create_time'=>'1678785098','update_time'=>'1678785098']);
        $this->insert('{{%user_store}}',['id'=>'278','user_id'=>'83','bloc_id'=>'91','store_id'=>'184','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'277','user_id'=>'83','bloc_id'=>'91','store_id'=>'183','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'196','user_id'=>'11','bloc_id'=>'83','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687171654','update_time'=>'1687171654']);
        $this->insert('{{%user_store}}',['id'=>'197','user_id'=>'11','bloc_id'=>'84','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687173459','update_time'=>'1687173459']);
        $this->insert('{{%user_store}}',['id'=>'198','user_id'=>'11','bloc_id'=>'85','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687173730','update_time'=>'1687173730']);
        $this->insert('{{%user_store}}',['id'=>'199','user_id'=>'11','bloc_id'=>'86','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687184348','update_time'=>'1687184348']);
        $this->insert('{{%user_store}}',['id'=>'200','user_id'=>'11','bloc_id'=>'87','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687184375','update_time'=>'1687184375']);
        $this->insert('{{%user_store}}',['id'=>'201','user_id'=>'11','bloc_id'=>'88','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687184644','update_time'=>'1687184644']);
        $this->insert('{{%user_store}}',['id'=>'202','user_id'=>'11','bloc_id'=>'89','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687184693','update_time'=>'1687184693']);
        $this->insert('{{%user_store}}',['id'=>'203','user_id'=>'11','bloc_id'=>'90','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687184822','update_time'=>'1687184822']);
        $this->insert('{{%user_store}}',['id'=>'204','user_id'=>'11','bloc_id'=>'38','store_id'=>'151','status'=>'1','is_default'=>'0','create_time'=>'1687224884','update_time'=>'1687224884']);
        $this->insert('{{%user_store}}',['id'=>'205','user_id'=>'11','bloc_id'=>'38','store_id'=>'152','status'=>'1','is_default'=>'0','create_time'=>'1687224892','update_time'=>'1687224892']);
        $this->insert('{{%user_store}}',['id'=>'206','user_id'=>'11','bloc_id'=>'91','store_id'=>'0','status'=>'1','is_default'=>'0','create_time'=>'1687227307','update_time'=>'1687227307']);
        $this->insert('{{%user_store}}',['id'=>'207','user_id'=>'11','bloc_id'=>'91','store_id'=>'153','status'=>'1','is_default'=>'1','create_time'=>'1687228915','update_time'=>'1687228915']);
        $this->insert('{{%user_store}}',['id'=>'272','user_id'=>'83','bloc_id'=>'91','store_id'=>'177','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'209','user_id'=>'406','bloc_id'=>'38','store_id'=>'163','status'=>'1','is_default'=>'1','create_time'=>'1687230583','update_time'=>'1687230583']);
        $this->insert('{{%user_store}}',['id'=>'210','user_id'=>'406','bloc_id'=>'38','store_id'=>'174','status'=>'1','is_default'=>'1','create_time'=>'1687231458','update_time'=>'1687231458']);
        $this->insert('{{%user_store}}',['id'=>'211','user_id'=>'11','bloc_id'=>'91','store_id'=>'174','status'=>'0','is_default'=>'0','create_time'=>'1687232293','update_time'=>'1687232293']);
        $this->insert('{{%user_store}}',['id'=>'212','user_id'=>'406','bloc_id'=>'38','store_id'=>'175','status'=>'1','is_default'=>'1','create_time'=>'1687237426','update_time'=>'1687237426']);
        $this->insert('{{%user_store}}',['id'=>'213','user_id'=>'406','bloc_id'=>'38','store_id'=>'176','status'=>'1','is_default'=>'1','create_time'=>'1687237684','update_time'=>'1687237684']);
        $this->insert('{{%user_store}}',['id'=>'271','user_id'=>'83','bloc_id'=>'91','store_id'=>'174','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'215','user_id'=>'674','bloc_id'=>'91','store_id'=>'177','status'=>'1','is_default'=>'1','create_time'=>'1687309681','update_time'=>'1687309681']);
        $this->insert('{{%user_store}}',['id'=>'216','user_id'=>'406','bloc_id'=>'38','store_id'=>'178','status'=>'1','is_default'=>'1','create_time'=>'1687315366','update_time'=>'1687315366']);
        $this->insert('{{%user_store}}',['id'=>'217','user_id'=>'674','bloc_id'=>'91','store_id'=>'179','status'=>'1','is_default'=>'1','create_time'=>'1687327840','update_time'=>'1687327840']);
        $this->insert('{{%user_store}}',['id'=>'218','user_id'=>'674','bloc_id'=>'91','store_id'=>'180','status'=>'1','is_default'=>'1','create_time'=>'1687328050','update_time'=>'1687328050']);
        $this->insert('{{%user_store}}',['id'=>'219','user_id'=>'674','bloc_id'=>'91','store_id'=>'181','status'=>'1','is_default'=>'1','create_time'=>'1687328434','update_time'=>'1687328434']);
        $this->insert('{{%user_store}}',['id'=>'220','user_id'=>'674','bloc_id'=>'91','store_id'=>'182','status'=>'1','is_default'=>'1','create_time'=>'1687328504','update_time'=>'1687328504']);
        $this->insert('{{%user_store}}',['id'=>'221','user_id'=>'674','bloc_id'=>'91','store_id'=>'183','status'=>'1','is_default'=>'1','create_time'=>'1687328573','update_time'=>'1687328573']);
        $this->insert('{{%user_store}}',['id'=>'222','user_id'=>'406','bloc_id'=>'91','store_id'=>'184','status'=>'1','is_default'=>'1','create_time'=>'1687683539','update_time'=>'1687683539']);
        $this->insert('{{%user_store}}',['id'=>'223','user_id'=>'11','bloc_id'=>'91','store_id'=>'177','status'=>'0','is_default'=>'0','create_time'=>'1687683981','update_time'=>'1687683981']);
        $this->insert('{{%user_store}}',['id'=>'224','user_id'=>'11','bloc_id'=>'91','store_id'=>'179','status'=>'0','is_default'=>'0','create_time'=>'1687683981','update_time'=>'1687683981']);
        $this->insert('{{%user_store}}',['id'=>'225','user_id'=>'11','bloc_id'=>'91','store_id'=>'184','status'=>'0','is_default'=>'0','create_time'=>'1687683981','update_time'=>'1687683981']);
        $this->insert('{{%user_store}}',['id'=>'226','user_id'=>'674','bloc_id'=>'91','store_id'=>'185','status'=>'1','is_default'=>'1','create_time'=>'1687829216','update_time'=>'1687829216']);
        $this->insert('{{%user_store}}',['id'=>'227','user_id'=>'674','bloc_id'=>'91','store_id'=>'186','status'=>'1','is_default'=>'1','create_time'=>'1687829228','update_time'=>'1687829228']);
        $this->insert('{{%user_store}}',['id'=>'228','user_id'=>'674','bloc_id'=>'91','store_id'=>'187','status'=>'1','is_default'=>'1','create_time'=>'1687829419','update_time'=>'1687829419']);
        $this->insert('{{%user_store}}',['id'=>'229','user_id'=>'674','bloc_id'=>'91','store_id'=>'188','status'=>'1','is_default'=>'1','create_time'=>'1687829429','update_time'=>'1687829429']);
        $this->insert('{{%user_store}}',['id'=>'230','user_id'=>'674','bloc_id'=>'91','store_id'=>'189','status'=>'1','is_default'=>'1','create_time'=>'1687829594','update_time'=>'1687829594']);
        $this->insert('{{%user_store}}',['id'=>'231','user_id'=>'694','bloc_id'=>'91','store_id'=>'190','status'=>'1','is_default'=>'1','create_time'=>'1687829893','update_time'=>'1687829893']);
        $this->insert('{{%user_store}}',['id'=>'232','user_id'=>'694','bloc_id'=>'91','store_id'=>'191','status'=>'1','is_default'=>'1','create_time'=>'1687829921','update_time'=>'1687829921']);
        $this->insert('{{%user_store}}',['id'=>'233','user_id'=>'694','bloc_id'=>'91','store_id'=>'192','status'=>'1','is_default'=>'1','create_time'=>'1687830179','update_time'=>'1687830179']);
        $this->insert('{{%user_store}}',['id'=>'234','user_id'=>'694','bloc_id'=>'91','store_id'=>'193','status'=>'1','is_default'=>'1','create_time'=>'1687830569','update_time'=>'1687830569']);
        $this->insert('{{%user_store}}',['id'=>'235','user_id'=>'694','bloc_id'=>'91','store_id'=>'194','status'=>'1','is_default'=>'1','create_time'=>'1687830615','update_time'=>'1687830615']);
        $this->insert('{{%user_store}}',['id'=>'236','user_id'=>'694','bloc_id'=>'91','store_id'=>'195','status'=>'1','is_default'=>'1','create_time'=>'1687830890','update_time'=>'1687830890']);
        $this->insert('{{%user_store}}',['id'=>'237','user_id'=>'694','bloc_id'=>'91','store_id'=>'196','status'=>'1','is_default'=>'1','create_time'=>'1687833593','update_time'=>'1687833593']);
        $this->insert('{{%user_store}}',['id'=>'238','user_id'=>'694','bloc_id'=>'91','store_id'=>'197','status'=>'1','is_default'=>'1','create_time'=>'1687836282','update_time'=>'1687836282']);
        $this->insert('{{%user_store}}',['id'=>'239','user_id'=>'694','bloc_id'=>'91','store_id'=>'198','status'=>'1','is_default'=>'1','create_time'=>'1687836323','update_time'=>'1687836323']);
        $this->insert('{{%user_store}}',['id'=>'240','user_id'=>'694','bloc_id'=>'91','store_id'=>'199','status'=>'1','is_default'=>'1','create_time'=>'1687837627','update_time'=>'1687837627']);
        $this->insert('{{%user_store}}',['id'=>'241','user_id'=>'694','bloc_id'=>'91','store_id'=>'200','status'=>'1','is_default'=>'1','create_time'=>'1687837636','update_time'=>'1687837636']);
        $this->insert('{{%user_store}}',['id'=>'242','user_id'=>'694','bloc_id'=>'91','store_id'=>'201','status'=>'1','is_default'=>'1','create_time'=>'1687844551','update_time'=>'1687844551']);
        $this->insert('{{%user_store}}',['id'=>'243','user_id'=>'694','bloc_id'=>'91','store_id'=>'202','status'=>'1','is_default'=>'1','create_time'=>'1687844574','update_time'=>'1687844574']);
        $this->insert('{{%user_store}}',['id'=>'244','user_id'=>'11','bloc_id'=>'91','store_id'=>'180','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'245','user_id'=>'11','bloc_id'=>'91','store_id'=>'181','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'246','user_id'=>'11','bloc_id'=>'91','store_id'=>'182','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'247','user_id'=>'11','bloc_id'=>'91','store_id'=>'183','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'248','user_id'=>'11','bloc_id'=>'91','store_id'=>'185','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'249','user_id'=>'11','bloc_id'=>'91','store_id'=>'186','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'250','user_id'=>'11','bloc_id'=>'91','store_id'=>'187','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'251','user_id'=>'11','bloc_id'=>'91','store_id'=>'188','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'252','user_id'=>'11','bloc_id'=>'91','store_id'=>'189','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'253','user_id'=>'11','bloc_id'=>'91','store_id'=>'190','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'254','user_id'=>'11','bloc_id'=>'91','store_id'=>'191','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'255','user_id'=>'11','bloc_id'=>'91','store_id'=>'192','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'256','user_id'=>'11','bloc_id'=>'91','store_id'=>'193','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'257','user_id'=>'11','bloc_id'=>'91','store_id'=>'194','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'258','user_id'=>'11','bloc_id'=>'91','store_id'=>'195','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'259','user_id'=>'11','bloc_id'=>'91','store_id'=>'196','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'260','user_id'=>'11','bloc_id'=>'91','store_id'=>'197','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'261','user_id'=>'11','bloc_id'=>'91','store_id'=>'198','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'262','user_id'=>'11','bloc_id'=>'91','store_id'=>'199','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'263','user_id'=>'11','bloc_id'=>'91','store_id'=>'200','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'264','user_id'=>'11','bloc_id'=>'91','store_id'=>'201','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'265','user_id'=>'11','bloc_id'=>'91','store_id'=>'202','status'=>'0','is_default'=>'0','create_time'=>'1687846518','update_time'=>'1687846518']);
        $this->insert('{{%user_store}}',['id'=>'266','user_id'=>'694','bloc_id'=>'91','store_id'=>'203','status'=>'1','is_default'=>'1','create_time'=>'1687853754','update_time'=>'1687853754']);
        $this->insert('{{%user_store}}',['id'=>'267','user_id'=>'694','bloc_id'=>'91','store_id'=>'204','status'=>'1','is_default'=>'1','create_time'=>'1687855019','update_time'=>'1687855019']);
        $this->insert('{{%user_store}}',['id'=>'268','user_id'=>'694','bloc_id'=>'91','store_id'=>'205','status'=>'1','is_default'=>'1','create_time'=>'1687857762','update_time'=>'1687857762']);
        $this->insert('{{%user_store}}',['id'=>'269','user_id'=>'694','bloc_id'=>'91','store_id'=>'206','status'=>'1','is_default'=>'1','create_time'=>'1687935716','update_time'=>'1687935716']);
        $this->insert('{{%user_store}}',['id'=>'279','user_id'=>'83','bloc_id'=>'91','store_id'=>'185','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'280','user_id'=>'83','bloc_id'=>'91','store_id'=>'186','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'281','user_id'=>'83','bloc_id'=>'91','store_id'=>'187','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'282','user_id'=>'83','bloc_id'=>'91','store_id'=>'188','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'283','user_id'=>'83','bloc_id'=>'91','store_id'=>'189','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'284','user_id'=>'83','bloc_id'=>'91','store_id'=>'190','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'285','user_id'=>'83','bloc_id'=>'91','store_id'=>'191','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'286','user_id'=>'83','bloc_id'=>'91','store_id'=>'192','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'287','user_id'=>'83','bloc_id'=>'91','store_id'=>'193','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'288','user_id'=>'83','bloc_id'=>'91','store_id'=>'194','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'289','user_id'=>'83','bloc_id'=>'91','store_id'=>'195','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'290','user_id'=>'83','bloc_id'=>'91','store_id'=>'196','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'291','user_id'=>'83','bloc_id'=>'91','store_id'=>'197','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'292','user_id'=>'83','bloc_id'=>'91','store_id'=>'198','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'293','user_id'=>'83','bloc_id'=>'91','store_id'=>'199','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'294','user_id'=>'83','bloc_id'=>'91','store_id'=>'200','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'295','user_id'=>'83','bloc_id'=>'91','store_id'=>'201','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'296','user_id'=>'83','bloc_id'=>'91','store_id'=>'202','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'297','user_id'=>'83','bloc_id'=>'91','store_id'=>'203','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'298','user_id'=>'83','bloc_id'=>'91','store_id'=>'204','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'299','user_id'=>'83','bloc_id'=>'91','store_id'=>'205','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'300','user_id'=>'83','bloc_id'=>'91','store_id'=>'206','status'=>'0','is_default'=>'0','create_time'=>'1698590412','update_time'=>'1698590412']);
        $this->insert('{{%user_store}}',['id'=>'301','user_id'=>'84','bloc_id'=>'91','store_id'=>'153','status'=>'0','is_default'=>'1','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'302','user_id'=>'84','bloc_id'=>'91','store_id'=>'174','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'303','user_id'=>'84','bloc_id'=>'91','store_id'=>'177','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'304','user_id'=>'84','bloc_id'=>'91','store_id'=>'179','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'305','user_id'=>'84','bloc_id'=>'91','store_id'=>'180','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'306','user_id'=>'84','bloc_id'=>'91','store_id'=>'181','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'307','user_id'=>'84','bloc_id'=>'91','store_id'=>'182','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'308','user_id'=>'84','bloc_id'=>'91','store_id'=>'183','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'309','user_id'=>'84','bloc_id'=>'91','store_id'=>'184','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'310','user_id'=>'84','bloc_id'=>'91','store_id'=>'185','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'311','user_id'=>'84','bloc_id'=>'91','store_id'=>'186','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'312','user_id'=>'84','bloc_id'=>'91','store_id'=>'187','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'313','user_id'=>'84','bloc_id'=>'91','store_id'=>'188','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'314','user_id'=>'84','bloc_id'=>'91','store_id'=>'189','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'315','user_id'=>'84','bloc_id'=>'91','store_id'=>'190','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'316','user_id'=>'84','bloc_id'=>'91','store_id'=>'191','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'317','user_id'=>'84','bloc_id'=>'91','store_id'=>'192','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'318','user_id'=>'84','bloc_id'=>'91','store_id'=>'193','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'319','user_id'=>'84','bloc_id'=>'91','store_id'=>'194','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'320','user_id'=>'84','bloc_id'=>'91','store_id'=>'195','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'321','user_id'=>'84','bloc_id'=>'91','store_id'=>'196','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'322','user_id'=>'84','bloc_id'=>'91','store_id'=>'197','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'323','user_id'=>'84','bloc_id'=>'91','store_id'=>'198','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'324','user_id'=>'84','bloc_id'=>'91','store_id'=>'199','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'325','user_id'=>'84','bloc_id'=>'91','store_id'=>'200','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'326','user_id'=>'84','bloc_id'=>'91','store_id'=>'201','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'327','user_id'=>'84','bloc_id'=>'91','store_id'=>'202','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'328','user_id'=>'84','bloc_id'=>'91','store_id'=>'203','status'=>'0','is_default'=>'0','create_time'=>'1698590817','update_time'=>'1698590817']);
        $this->insert('{{%user_store}}',['id'=>'329','user_id'=>'84','bloc_id'=>'91','store_id'=>'204','status'=>'0','is_default'=>'0','create_time'=>'1698590818','update_time'=>'1698590818']);
        $this->insert('{{%user_store}}',['id'=>'330','user_id'=>'84','bloc_id'=>'91','store_id'=>'205','status'=>'0','is_default'=>'0','create_time'=>'1698590818','update_time'=>'1698590818']);
        $this->insert('{{%user_store}}',['id'=>'331','user_id'=>'84','bloc_id'=>'91','store_id'=>'206','status'=>'0','is_default'=>'0','create_time'=>'1698590818','update_time'=>'1698590818']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

