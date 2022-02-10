<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-02-29 22:47:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-27 02:21:39
 */
use richardfan\widget\JSRegister;

$topNav = Yii::$app->params['topNav'];

$initmenu = Yii::$app->params['leftNav'];

?>


<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2013-2020 <a href="http://www.wayfirer.com/">店滴AI·途火科技</a></strong> All rights
    reserved.
</footer>

<?= $this->render(
    'sidebar.php',
    ['content' => $content, 'directoryAsset' => $directoryAsset]
); ?>


<?php JSRegister::begin([
    'id' => '1',
]); ?>

<script>
    /**
     * 本地搜索菜单
     */
    function search_menu() {
        //要搜索的值
        var text = $('input[name=q]').val();

        var $ul = $('.sidebar-menu');
        $ul.find("a.nav-link").each(function() {
            var $a = $(this).css("border", "");

            //判断是否含有要搜索的字符串
            if ($a.children("span.menu-text").text().indexOf(text) >= 0) {

                //如果a标签的父级是隐藏的就展开
                $ul = $a.parents("ul");

                if ($ul.is(":hidden")) {
                    $a.parents("ul").prev().click();
                }

                //点击该菜单
                $a.click().css("border", "1px solid");

                //                return false;
            }
        });
    }


    $(function() {
        var is_addons = "<?= $is_addons; ?>"
        App.setbasePath("<?= $directoryAsset ?>");
        App.setGlobalImgPath("/dist/img/");
        addTabs({
            id: '10008',
            title: '欢迎页',
            close: false,
            url: "<?= Yii::$app->params['welcomeUrl']; ?>",
            urlType: "relative"
        });
        
        // 全局打开新页面事件
        function openTabs(){
            addTabs({
                id: '10008',
                title: '欢迎页',
                close: false,
                url: "<?= Yii::$app->params['welcomeUrl']; ?>",
                urlType: "relative"
            });
        }

        App.fixIframeCotent();

        /*addTabs({
         id: '10009',
         title: '404',
         close: true,
         url: 'UI/buttons_iframe2.html'
         });*/

       
        let storeSeleted = localStorage.getItem("bloc"); 
        
        if(storeSeleted){
            $('#bloc-left-name').text(JSON.parse(storeSeleted).store_name);        
        }
        
        $('.sidebar-menu').sidebarMenu({
                data: <?= $initmenu; ?>
        });


        $('#top-nav').sidebarMenu({
            data: <?= $topNav; ?>
        });

        // 动态创建菜单后，可以重新计算 SlimScroll
        // $.AdminLTE.layout.fixSidebar();
        // // $.AdminLTE.options.change_skin('skin-yellow')
        // if ($.AdminLTE.options.sidebarSlimScroll) {

        //     if ($(window).width() <= 700) {
        //         $('.left-treeview').addClass('show').removeClass('hide')
        //     }
        //     if (typeof $.fn.slimScroll != 'undefined') {
        //         //Destroy if it exists
        //         var $sidebar = $(".sidebar");
        //         $sidebar.slimScroll({
        //             destroy: true
        //         }).height("auto");
        //         //Add slimscroll
        //         $sidebar.slimscroll({
        //             height: ($(window).height() - $(".main-header").height()) + "px",
        //             color: "rgba(0,0,0,0.2)",
        //             size: "3px"
        //         });
        //     }
        // }
    });
   
</script>

<?php JSRegister::end(); ?>

