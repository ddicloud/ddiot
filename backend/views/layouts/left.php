<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 11:01:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-10-14 14:38:43
 */

use common\helpers\ImageHelper;

?>

<fire-sidebar-logo :title="Website.name" :logo="Website.blogo" :background="menuBgColor" :borderRight="menuTextColor"></fire-sidebar-logo>
<div class="sidebar">

    <el-menu class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose" :collapse="isCollapse">

        <template v-for="(item,index) in leftMenu" v-if=" item.type == menuCate || isLeftAll">

            <el-submenu :index="index" v-show="item.children.length>0">
                <template slot="title">
                    <i :class="item.icon"></i>
                    <span slot="title">{{item.text}}</span>
                </template>
                <template :index="index+'-'+childIndex" v-for="(child,childIndex) in item.children">
                    <el-menu-item-group v-if="child.children.length==0">
                        <el-menu-item :index="index+'-'+childIndex" @click="addTabs(child)">
                            <template slot="title">
                                <i :class="child.icon"></i>
                                <span slot="title">{{child.text}}</span>
                            </template>
                        </el-menu-item>
                    </el-menu-item-group>
                    <el-submenu :index="index+'-'+childIndex" v-if="child.children.length > 0">
                        <template slot="title">
                            <i :class="child.icon"></i>
                            <span slot="title">{{child.text}}</span>
                        </template>
                        <el-menu-item @click="addTabs(grandson)" :index="index+'-'+childIndex+'-'+grandsonIndex" v-for="(grandson,grandsonIndex) in child.children">
                            <template slot="title">
                                <i :class="grandson.icon"></i>
                                <span slot="title">{{grandson.text}}</span>
                            </template>
                        </el-menu-item>
                    </el-submenu>
                </template>


            </el-submenu>

            <el-menu-item :index="index" @click="addTabs(item)" v-show="item.children.length==0">
                <i :class="item.icon"></i>
                <span slot="title">{{item.text}}</span>
            </el-menu-item>

        </template>
    </el-menu>

</div>