<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 18:19:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-16 15:52:00
 */

use common\components\backend\VueBackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$this->title = '开发者助手';
VueBackendAsset::register($this);

?>

<div class="firetech-main" id="gii-main">

      <el-page-header  @back="goBack"  title="代码生成器"  content="一个神奇的工具，可以为您编写代码">
      
      </el-page-header>


      <div class="panel-body">
            <el-row :gutter="24">
                  <?php foreach ($generators as $id => $generator) : ?>
                        <el-col :span="12" class="margin-top">
                              <el-card :body-style="{ padding: '0px' }" shadow="hover">
                                    <div style="padding: 14px;">
                                          <el-row class="row-fluid" style="height: 50px;"><?= $generator->getDescription(); ?></el-row>
                                          <div class="bottom clearfix">
                                                <el-link href="<?= Url::to(['default/view', 'id' => $id]); ?>" target="_blank">
                                                      <el-button type="primary" size="mini">

                                                            <?= Html::encode($generator->getName()); ?>
                                                      </el-button>

                                                </el-link>

                                          </div>
                                    </div>
                              </el-card>
                        </el-col>
                  <?php endforeach; ?>

            </el-row>

            <el-row class="margin-top">
                  <el-link href="https://www.hopesfire.com/" target="_blank">
                        <el-button type="primary" size="mini">

                        学习快速开发教程
                        </el-button>

                  </el-link>
            </el-row>
      </div>
      

</div>