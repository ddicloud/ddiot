<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 20:41:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 16:52:09
 */

use yii\helpers\Html;
use yii\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

$asset = yii\gii\GiiAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="none">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
    <style>
        .bg-gii {
            background-color: none;
            border-bottom: 1px solid #343a40;
        }
        .nav-links{
            width: 80px;
            display: inline-flex;
            color: #313131;
    font-size: 16px;
        }
        .navbar{
            position: relative;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <?php $this->beginBody(); ?>
        <nav class="navbar navbar-expand-md navbar-dark bg-gii">
            <div class="container">
                <?php echo Html::a(Html::img('https://www.dandicloud.com/static/logo.png', [
                    'height' => '50',
                ]), ['default/index'], [
                    'class' => ['navbar-brand'],
                ]); ?>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#gii-nav"
                        aria-controls="gii-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="gii-nav">
                    <?php
                        echo Menu::widget([
                            'options' => ['class' => ['navbar-nav', 'ml-auto']],
                            'activateItems' => true,
                            'itemOptions' => [
                                'class' => ['nav-item'],
                            ],
                            'linkTemplate' => '<a class="nav-links" href="{url}" target="_block">{label}</a>',
                            'items' => [
                                ['label' => '官方网站', 'url' => 'https://www.dandicloud.com/'],
                                ['label' => '开发手册', 'url' => 'https://doc.ddicms.com/'],
                                ['label' => '官方sdk', 'url' => 'https://ext.dcloud.net.cn/plugin?id=13579'],
                            ],
                    ]);
                    ?>
                </div>
            </div>
        </nav>
        <div class="container" style="margin-top: 20px;">
            <?= $content; ?>
        </div>
        <div class="footer-fix"></div>
    </div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
