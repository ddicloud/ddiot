<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 09:16:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-21 17:28:56
 */

namespace common\components\addons;

use common\helpers\FileHelper;
use Yii;
use yii\web\AssetBundle;

class AddonsAsset extends AssetBundle
{
    // public $basePath = '@webroot/assetsaddons/diandi_distribution';

    // public $baseUrl = '@web/assetsaddons/diandi_distribution';

    /**
     * {@inheritdoc}
     */
    public $sourcePath = '';

    public $version;

    /**
     * {@inheritdoc}
     */
    public $css = [];
    /**
     * {@inheritdoc}
     */
    public $js = [];

    public $jsOptions = [
        'type' => 'module'
    ];
  
    /**
     * {@inheritdoc}
     */
    public $depends = [
        // 'yii\web\JqueryAsset',
        'common\widgets\firevue\VuemainAsset'
    ];

    public $action = '';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        global $_GPC;
        $module = Yii::$app->controller->module->id;
        
        if(is_dir(Yii::getAlias('@addons/'.$module))){
          $controllerPath = Yii::$app->controller->id;
          $actionName  = Yii::$app->controller->action->id;
          $this->sourcePath = sprintf('@addons/%s/assets/', trim($module));
          
          FileHelper::mkdirs(Yii::getAlias($this->sourcePath.$controllerPath));
  
          $path = Yii::getAlias($this->sourcePath.$controllerPath.'/'.$actionName.'.js');
          
          if(is_file($path)){
              $this->js[] = $controllerPath.'/'.$actionName.'.js';             
          }
        }
       
        
        parent::init();
    }

    
    public function createDemoJs($module,$controllerPath,$actionName)
    {
        global $_GPC;
        $sourcePath = sprintf('@addons/%s/assets/', trim($module));
        
        FileHelper::mkdirs(Yii::getAlias($sourcePath.$controllerPath));

        $path = Yii::getAlias($sourcePath.$controllerPath.'/'.$actionName.'.js');
        
        if(!is_file($path)){
            $content = $this->demoJs();
            file_put_contents($path,$content, FILE_APPEND);
            $this->js[] = $controllerPath.'/'.$actionName.'.js';             
        }
    }

    public function demoJs()
    {   
        return <<<EOF
        new Vue({
            el: '#dd-member-index',//当前页面id
            data: function () {
                return {
                    listKey:'member_id',//列表数据主键
                    height:'',
                    imgShow: true,
                    downloadLoading: false,
                    list: [],//列表数据
                    imageList: [],
                    listLoading: true,
                    layout: 'total, sizes, prev, pager, next, jumper',//分页显示参数
                    total: 0,//数据总数
                    background: true,//是否为分页按钮添加背景色
                    selectRows: '',//多行选择选择的集合
                    elementLoadingText: '正在加载...',
                    SearchFields:{},
                    queryForm: {
                      pageNo: 1,
                      pageSize: 10,
                      title: '',
                    },
                    searchModel:'DdMemberSearch',
                    excelConfig:{//需要导出的excel参数配置
                      tHeader : ['member_id','group_id','level','openid','store_id','bloc_id','username','mobile','address','nickName','avatarUrl','gender','country','province','status','city','address_id','wxapp_id','verification_token','create_time','update_time','auth_key','password_hash','password_reset_token','realname','avatar','qq','vip','birthyear','constellation','zodiac','telephone','idcard','studentid','grade','zipcode','nationality','resideprovince','graduateschool','company','education','occupation','position','revenue','affectivestatus','lookingfor','bloodtype','height','weight','alipay','msn','email','taobao','site','bio','interest'
                    ],//要显示的字段
                      filterVal : ['create_time','update_time','auth_key','password_hash','password_reset_token'],//需要过滤的字段
                      filename:'2020-11-03',//保存的文件名称
                      autoWidth: 100,//宽度
                      bookType: ''//类型
                    }
                }
            },
            created: function () {
                let that = this;
                console.log('全局设置是否可以',window.sysinfo,window.innerHeight)
                console.log('a is: ' + this.DistributionGoods,window.innerWidth)
                if(window.innerWidth<700){
                  that.layout = 'prev,pager, next'
                }
                that.init();
            },
            methods: {
              // 初始化页面数据
              init(){
                let that = this;
                that.getList();
              },
              // 获取列表数据
              getList(queryForm){
                let that = this;
                let pageSize = that.queryForm.pageSize,
                    pageNo = that.queryForm.pageNo,
                    searchModel = that.searchModel
                    that.listLoading = true
                let data = {
                  pageSize:pageSize,
                  page:pageNo,
                }
                
                that.\$set(data,searchModel,that.queryForm[that.searchModel]);
                console.log('提交数据',data,searchModel)
                    that.\$http.post('index', data).then((response) => {
                        //响应成功回调
                        if (response.data.code == 200) {
                          that.list = response.data.data.dataProvider.allModels
                          that.total = response.data.data.dataProvider.total
                        }
                        setTimeout(() => {
                          this.listLoading = false
                        }, 500)
                        return false;
                    }, (response) => {
                        //响应错误回调
                        console.log(response)
                    });
        
              },
              // 检索
              onSearch() {
                let that = this
                console.log('submit!');
                let queryForm =  that.queryForm
                    queryForm[that.searchModel] = that.SearchFields
                    that.getList(queryForm)
              },
              tableSortChange() {
                const imageList = []
                this.\$refs.tableSort.tableData.forEach((item, index) => {
                  imageList.push(item.img)
                })
                this.imageList = imageList
              },
              setSelectRows(val) {
                this.selectRows = val
              },
              handleView(row){
                let that = this
                console.log(row,row[this.listKey])
                that.Popup({
                  url:'view?id='+row[this.listKey],
                  title:'店滴AI555',
                  
                  openbefore: () => {
                    // 点击按钮事件
                    console.log('打开前前')
                  }
                })
                
              },
              handleEdit(row) {
                let that = this
                that.Popup({
                  url:'update?id='+row[this.listKey],
                  title:'更新',
                  
                  openbefore: () => {
                    // 点击按钮事件
                    console.log('打开前前')
                  }
                })
              },
              handleDelete(row) {
                let that = this
                if (row[this.listKey]) {
                  that.\$confirm('确认删除吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                  }).then(() => {
                    that.doDelete(row[this.listKey])
                    that.getList(that.queryForm)
                    this.\$message({
                      message: '删除成功',
                      type: 'success'
                    });
                  }).catch(() => {
                    this.\$message({
                      type: 'info',
                      message: '已取消删除'
                    });          
                  });
                  
                } else {
                  if (this.selectRows.length > 0) {
                    const ids = this.selectRows.map((item) => item[this.listKey]).join()
                    that.\$confirm('确认删除吗?', '提示', {
                      confirmButtonText: '确定',
                      cancelButtonText: '取消',
                      type: 'warning'
                    }).then(() => {
                      that.doDelete(ids)
                      that.getList(that.queryForm)
                      this.\$message({
                        message: '删除成功',
                        type: 'success'
                      });
                    }).catch(() => {
                      this.\$message({
                        type: 'info',
                        message: '已取消删除'
                      });          
                    });
                    
                  } else {
                    this.\$message.error('未选中任何行')
                    return false
                  }
                }
              },
              handleSizeChange(val) {
                console.log(1)
                let that = this
        
                that.queryForm.pageSize = val
                that.getList(that.queryForm)
                
              },
              handleCurrentChange(val) {
                console.log(2)
                let that = this
                
                that.queryForm.pageNo = val
                that.getList(that.queryForm)
                
              },
              doDelete(ids){
                let that  = this
                that.\$http.post('delete', {
                  ids:ids
                }).then((response) => {
                    console.log(response)
                    //响应成功回调
                    if (response.data.code == 200) {
                      
                    }
                    
                }, (response) => {
                    //响应错误回调
                    console.log(response)
                });
              },
              // 导出excel
              handleDownload() {
                let that = this
                that.downloadLoading = true
                console.log('全局变量',that)
                
                const list = this.list
                const data = this.global.formatJson(that.excelConfig.filterVal, list)
                that.export_json_to_excel({
                  header: that.excelConfig.tHeader,
                  data,
                  filename: that.excelConfig.filename+'.xlsx',
                  autoWidth: that.excelConfig.autoWidth,
                  bookType: that.excelConfig.bookType
                })
                this.downloadLoading = false
                
              },
          }
        })
EOF;

    }

   
    
}
