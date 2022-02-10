<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 15:31:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-11 15:52:40
 */

use yii\helpers\Html;
use common\helpers\ImageHelper;

$settings = Yii::$app->settings;
$menucate = Yii::$app->service->backendNavService->getMenu('left');
$moduleAll =  Yii::$app->params['moduleAll'];
?>
<el-row type="flex"  :gutter="0" class="main-header"  :style="{ 'border-bottom' : '1px solid' + menuBgColor,background:menuBgColor }">
  <el-col :xs="3" :sm="2" :md="1" :lg="1" :xl="1" style="min-width: 65px;">
        <el-menu :default-active="activeIndex"  class="el-menu-demo" mode="horizontal"
                    :background-color="menuTextColor"
                    :text-color="menuBgColor"
                    :active-text-color="menuActiveColor"
                >
            <el-menu-item  @click="CollapseSet" class="hamburger"  :class="{'is-active':isCollapse}">
                <i class="el-icon-s-fold" :style="{ color : menuBgColor } " ></i>
            </el-menu-item>
        </el-menu>
  </el-col>  
  <el-col  :xs="8" :sm="6" :md="16" :lg="16" :xl="16" class="hidden-sm-and-down">
            <el-menu :default-active="0"
                            v-show="topMenu"
                            :background-color="menuBgColor"
                            :text-color="menuTextColor"
                            :active-text-color="menuActiveColor"
                
                 class="el-menu-demo" mode="horizontal" @select="menuTopSelect">
          
                    <el-menu-item :index="index"  v-for="(item,index) in topMenu" 
                        >{{item.text}}</el-menu-item>
                        <el-submenu index="addons" v-show="is_addons">
                            <template slot="title">切换模块</template>
                        <el-menu-item :index="item.module_name" v-for="(item,index) in moduleAll"  :data-addons="item">
                           {{item.addons.title}}
                        </el-menu-item>
                </el-submenu>
            </el-menu>
  </el-col>
  <el-col  :xs="21" :sm="22" :md="7" :lg="7" :xl="7" :background-color="menuBgColor">
        <el-row type="flex" justify="end" >
                <el-menu :default-active="activeIndex"
                                
                                :background-color="menuBgColor"
                                :text-color="menuTextColor"
                                :active-text-color="menuActiveColor"
        
                    class="el-menu-demo" mode="horizontal">
            
                            <el-menu-item  @click="selectStore">
                                <span id="bloc-left-name">点我选择商户</span>
                            </el-menu-item>
                            <el-submenu index="addons">
                                <template slot="title">
                                    <small><?= Yii::$app->user->identity->username; ?></small>
                                </template>
                                <el-menu-item  onclick="addTabs({title: '个人资料',close: true,url: '/admin/user/update?id=<?= Yii::$app->user->identity->id; ?>',urlType: 'relative'});">
                                    个人资料
                                </el-menu-item>
                                <el-menu-item  onclick="addTabs({title: '修改密码',close: true,url: '/site/reset-password?token=<?= Yii::$app->user->identity->password_reset_token; ?>',urlType: 'relative'});">
                                    修改密码
                                </el-menu-item>
                                <el-menu-item  onclick="addTabs({title: '清理缓存',close: true,url: '/system/settings/clear-cache',urlType: 'relative'});">
                                    清理缓存
                                </el-menu-item>
                                <el-menu-item  onclick="addTabs({title: '我的公司',close: true,url: '/addons/bloc/index',urlType: 'relative'});">
                                    我的公司
                                </el-menu-item>
                                <el-menu-item @click="loginOut">
                                    退出登录
                                </el-menu-item>

                            </el-submenu>
                            <el-menu-item class="hidden-xs-only"  data-toggle="control-sidebar">
                                <i class="fa fa-gears" :style="{ color : menuTextColor } "></i>
                            </el-menu-item>
                </el-menu>
        </el-row>
           
  </el-col>
</el-row>