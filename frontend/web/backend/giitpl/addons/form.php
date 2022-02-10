<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-30 16:57:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-02 15:08:12
 */

?>
<div class="box">
    <div class="box-body table-responsive">
        <div class="module-form">
            <?php
            echo $form->field($generator, 'moduleID');
            echo $form->field($generator, 'title');
            echo $form->field($generator, 'version');

            echo $form->field($generator, 'type')
                ->dropDownList([
                    'base' => '基础',
                    'business' => '商业',
                    'marketing' => '营销',
                    'member' => '会员',
                    'system' => '系统',
                    'enterprise' => '企业',
                    'services' => '服务',
                    'other' => '其他'
                ]);



            echo $form->field($generator, 'ability');
            echo $form->field($generator, 'description');
            echo $form->field($generator, 'author');
            echo $form->field($generator, 'url');
            ?>

        </div>
    </div>
</div>