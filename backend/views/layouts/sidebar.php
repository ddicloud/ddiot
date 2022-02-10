<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-02-27 02:46:02
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-27 04:54:28
 */
?>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <!-- <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li> -->
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
            <div>
                <h4 class="control-sidebar-heading">颜色风格</h4>
                <ul class="list-unstyled clearfix">
                    <li style="float: left; width: 33.3333%; padding: 5px;"  v-for="(item,index) in my_skins">
                    <a href="javascript:void(0);" 
                        class="clearfix full-opacity-hover" style="display: block; box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 3px;"
                        :data-bgcolor="item.bgColor" 
                        :data-skin="item.skinClass" 
                        :data-text="item.text" 
                        :data-active="item.active" 
                        @click="change_skin"
                       
                    >
                            <div>
                                <span style="display: block; width: 20%; float: left; height: 7px;"  :style="{ background : item.bgColor}"></span>
                                <span :class="item.bgClass" style="display: block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display: block; width: 20%; float: left; height: 20px; background: rgb(34, 45, 50);"></span>
                                <span style="display: block; width: 80%; float: left; height: 20px; background: rgb(244, 245, 247);"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin">{{item.title}}</p>
                    </li>

                    
                 
                </ul>
                <h4 class="control-sidebar-heading">布局选项</h4>
                <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="fixed" checked="checked" class="pull-right"> 宽屏布局</label>
                    <p>激活宽屏布局。不能同时使用宽屏布局和窄屏布局</p>
                </div>
                <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="layout-boxed" class="pull-right"> 窄屏布局</label>
                    <p>两边留空，操作区域小巧</p>
                </div>
                <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="sidebar-collapse" class="pull-right"> 折叠左侧导航</label>
                    <p>左侧导航默认折叠起来，鼠标放置后打开</p>
                </div>
                <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-enable="expandOnHover" class="pull-right"> 切换栏</label>
                    <p>切换左边栏的状态(打开或折叠)</p>
                </div>
                <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-controlsidebar="control-sidebar-open" class="pull-right"> 切换右侧侧边栏幻灯片</label>
                    <p>切换右侧侧边栏幻灯片</p>
                </div>
                <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-sidebarskin="toggle" class="pull-right"> 切换右边栏皮肤</label>
                    <p>在右边栏的深色皮肤和浅色皮肤之间切换</p>
                </div>
            </div>
        </div>

        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">

            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">

        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebars background. This div must be placed
         immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>