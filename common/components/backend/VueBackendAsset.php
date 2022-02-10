<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 09:16:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-21 17:06:51
 */

namespace common\components\backend;

use backend\assets\AppAsset;
use common\helpers\FileHelper;
use Yii;
use yii\web\AssetBundle;

class VueBackendAsset extends AssetBundle
{
    public $sourcePath = "@backend/assets";
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
        'yii\web\JqueryAsset',
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
        $controllerPath = Yii::$app->controller->id;
        $actionName  = Yii::$app->controller->action->id;
       
        $BaseDir = Yii::getAlias('@backend/assets/'.$controllerPath);
        
        FileHelper::mkdirs(Yii::getAlias($BaseDir));
        $path = Yii::getAlias($BaseDir.'/'.$actionName.'.js');
        if(is_file($path)){
            $this->js[] = $controllerPath.'/'.$actionName.'.js';             
        }else{
            $content = $this->demoJs();
            file_put_contents($path,$content, FILE_APPEND);
            $this->js[] = $controllerPath.'/'.$actionName.'.js';             
        }
        parent::init();
    }

   


    public function demoJs()
    {
        return "
        new Vue({
            el: '#operator-bloc-update',
            data: function () {
                return {
                    account:'',
                }
            },
            created: function () {
                let that = this;
                console.log('全局设置是否可以',window.sysinfo)
                console.log('a is: ' + this.DistributionGoods)
            },
            methods: {
              init(){
                let that = this;
                that.\$http.post('attribute', {a:1}).then((response) => {
                    //响应成功回调
                    if (response.data.code == 200) {
                      that.attribute =  that.global.objToar(response.data.data.attribute)
                      that.prices = Object.values(response.data.data.prices)
                    }
                    return false;
                }, (response) => {
                    //响应错误回调
                    console.log(response)
                });
        
              },
              selectBlocs() {
                    let that = this
                    console.log(that)
                    //Lambda写法
                    that.\$http.get('blocs', {}).then((response) => {
                       console.log('response',response)
                      // return false;
                        //响应成功回调
                        if (response.data.code == 200) {  
                          that.blocslist = response.data.data
                          that.visible = true
        
                        }
                    }, (response) => {
                        //响应错误回调
                        console.log('错误了',response)
                    });
            },
            setbloc(index,row){
                let that = this
                console.log(index,row)
                that.account = row.bloc_id
                that.name = row.business_name
                
                that.visible = false
        
            }
        
          }
        })
        ";
    }

   
    
}
