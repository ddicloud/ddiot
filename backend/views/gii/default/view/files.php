<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:06:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-25 00:50:43
 */
 

use yii\gii\CodeFile;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $generator \yii\gii\Generator */
/* @var $files CodeFile[] */
/* @var $answers array */
/* @var $id string panel ID */

?>
<div class="default-view-files">
    <p>点击上面的<code>生成按钮</code> 生成下面选择的文件的按钮:</p>

    <div class="row form-group">
        
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <input id="filter-input" class="form-control" placeholder="Type to filter">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right margin-top">
            <div id="action-toggle" class="btn-group btn-group-xs">
                <label class="btn btn-success active" title="Filter files that are created">
                    <input type="checkbox" value="<?= CodeFile::OP_CREATE ?>" checked> 创建
                </label>
                <label class="btn btn-outline-secondary active" title="Filter files that are unchanged.">
                    <input type="checkbox" value="<?= CodeFile::OP_SKIP ?>" checked> 没有变化
                </label>
                <label class="btn btn-warning active" title="Filter files that are overwritten">
                    <input type="checkbox" value="<?= CodeFile::OP_OVERWRITE ?>" checked> 覆盖
                </label>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th class="file">创建文件列表</th>
                <th class="action">操作</th>
                <?php
                $fileChangeExists = false;
                foreach ($files as $file) {
                    if ($file->operation !== CodeFile::OP_SKIP) {
                        $fileChangeExists = true;
                        echo '<th><input type="checkbox" id="check-all"></th>';
                        break;
                    }
                }
                ?>

            </tr>
        </thead>
        <tbody id="files-body">
            <?php foreach ($files as $file): ?>
                <?php
                if ($file->operation === CodeFile::OP_OVERWRITE) {
                    $trClass = 'table-warning';
                } elseif ($file->operation === CodeFile::OP_SKIP) {
                    $trClass = 'table-active';
                } elseif ($file->operation === CodeFile::OP_CREATE) {
                    $trClass = 'table-success';
                } else {
                    $trClass = '';
                }
                ?>
            <tr class="<?= "$file->operation $trClass" ?>">
                <td class="file">
                    <?= Html::a(Html::encode($file->getRelativePath()), ['preview', 'id' => $id, 'file' => $file->id], ['class' => 'preview-code', 'data-title' => $file->getRelativePath()]) ?>
                    <?php if ($file->operation === CodeFile::OP_OVERWRITE): ?>
                        <?= Html::a('diff', ['diff', 'id' => $id, 'file' => $file->id], ['class' => 'diff-code badge badge-warning', 'data-title' => $file->getRelativePath()]) ?>
                    <?php endif; ?>
                </td>
                <td class="action">
                    <?php
                    if ($file->operation === CodeFile::OP_SKIP) {
                        echo 'unchanged';
                    } else {
                        echo $file->operation;
                    }
                    ?>
                </td>
                <?php if ($fileChangeExists): ?>
                <td class="check">
                    <?php
                    if ($file->operation === CodeFile::OP_SKIP) {
                        echo '&nbsp;';
                    } else {
                        echo Html::checkBox("answers[{$file->id}]", isset($answers) ? isset($answers[$file->id]) : ($file->operation === CodeFile::OP_CREATE));
                    }
                    ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="preview-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="display: flex;">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="modal-previous btn btn-outline-secondary" href="#" title="Previous File (Left Arrow)">
                            <span class="icon"></span>
                        </a>
                        <a class="modal-next btn btn-outline-secondary" href="#" title="Next File (Right Arrow)">
                            <span class="icon"></span>
                        </a>
                        <a class="modal-refresh btn btn-outline-secondary" href="#" title="Refresh File (R)">
                            <span class="icon"></span>
                        </a>
                        <a class="modal-checkbox btn btn-outline-secondary" href="#" title="Check This File (Space)">
                            <span class="icon"></span>
                        </a>
                        &nbsp;
                    </div>
                    <h5 class="modal-title ml-2">Modal title</h5>
                    <span class="modal-copy-hint ml-auto"><kbd>CTRL</kbd>+<kbd>C</kbd> to copy</span>
                    <div id="clipboard-container"><textarea id="clipboard"></textarea></div>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please wait ...</p>
                </div>
            </div>
        </div>
    </div>
</div>
