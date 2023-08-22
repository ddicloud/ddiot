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
                <?php echo Html::a(Html::img('https://diandi-1255369109.cos.ap-nanjing.myqcloud.com/cms%2Flogo-dz.png?q-sign-algorithm=sha1&q-ak=AKIDCUzY7R8RngO4SHsZOaZ_gwfwTd0NYJWGAnZb3O-G7-mAxe7XY-G-xbqmgPoS5ZSR&q-sign-time=1656406318;1656409918&q-key-time=1656406318;1656409918&q-header-list=&q-url-param-list=&q-signature=3573d680b29090c5ca690ddf3251edc56784873b&x-cos-security-token=Hc5k50gLBn5VQumKCxqh9Fajy4parlcaca25f20b88281b821e4d7f686940cb7c5Ycb5x4ng5EtD-4hHwsSe9yc1FTBzLF8j5nF_Ekd826DNd98KiJPZnDCsMAzUZ_BSgMVH9RU1wzsfxVTx4MlWbFv2T48fsBWGth9oChohbLDqtAkD_ayXaeO3J_Yxw9Mcd6KGS8Cetm4s6ovz5POy-N4XJJfYcMLf2iMMVghT9kM_I3FzIfCNPeSDl4Kfz_O', [
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
                                ['label' => '开发社区', 'url' => 'https://www.hopesfire.com/'],
                                ['label' => '开发手册', 'url' => 'https://doc.hopesfire.com/'],
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
