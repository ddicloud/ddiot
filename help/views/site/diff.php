<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 20:16:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-25 00:45:32
 */

/* @var $this yii\web\View */
/* @var $diff mixed */
?>
<div class="default-diff">
    <?php if ($diff === false): ?>
        <div class="alert alert-danger">此文件类型不支持差异.</div>
    <?php elseif (empty($diff)): ?>
        <div class="alert alert-success">Identical.</div>
    <?php else: ?>
        <div class="content"><?= $diff ?></div>
    <?php endif; ?>
</div>
