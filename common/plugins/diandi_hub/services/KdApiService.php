<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-23 21:13:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-06 23:57:43
 */
namespace common\plugins\diandi_hub\services;


use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\express\HubExpressLog;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;
use yii\db\Transaction;

// 请到快递鸟官网申请http://kdniao.com/reg

class KdApiService extends BaseService
{
    public $modelClass = '';
    
    //电商ID
    static $EBusinessID='';

    //电商加密私钥，快递鸟提供，注意保管，不要泄漏
    static $AppKey='';
    
    //请求url
    static $ReqURL='https://api.kdniao.com/api/dist';

    // static $ReqURL='http://sandboxapi.kdniao.com:8080/kdniaosandbox/gateway/exterfaceInvoke.json';

    

    
    public static function initConf()
    {
        $conf = HubConfig::findOne(1);
        
        self::$EBusinessID = trim($conf['kd_id']);
        self::$AppKey = trim($conf['kd_key']);
    }

    /**
     * Json方式 查询订单物流轨迹
     */
    public static function getOrderTracesByJson($OrderCode,$ShipperCode,$LogisticCode){
        // 初始配置
        self::initConf();
        $requestData= [
            'OrderCode'     =>$OrderCode,
            'ShipperCode'   =>$ShipperCode,
            'LogisticCode'  =>$LogisticCode,
            'CustomerName'  =>'',
        ];
        
        
        $datas = array(
            'EBusinessID' => self::$EBusinessID,
            'RequestType' => '8008',
            'RequestData' => urlencode(json_encode($requestData)),
            'DataType' => '2',
        );
        $datas['DataSign'] = self::encrypt(json_encode($requestData), self::$AppKey);
        
        $result=  self::sendPost(self::$ReqURL, $datas);	
        
        $data  = json_decode($result,true);

        $express = HubExpressCompany::find()->where(['status'=>1,'code'=>$ShipperCode])->one();
        
        //根据公司业务处理返回的信息......
        $data['express_company'] = $express['title'];
        
        return  $data;
    }


    
    
    /**
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return string url响应返回的html
     */
    public static function sendPost($url, $datas) {
        $temps = array();	
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);		
        }	
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;	
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);  
        
        return $gets;
    }

    public static function saveKdninfo($RequestData)
    { 
        loggingHelper::writeLog('diandi_hub', 'KdApiService/saveKdninfo', '快递信息1',$RequestData);

        $initRequset = is_array($RequestData)?$RequestData:json_decode($RequestData,true);

        $Datalist = $initRequset['Data'][0]; 
        
        // p($initRequset,$initRequset['Data'],$initRequset['Data'][0]['Traces']);

        if(!empty($Datalist)){
            $EBusinessID    = $Datalist['EBusinessID'];
            $LogisticCode   = $Datalist['LogisticCode'];
            $ShipperCode    = $Datalist['ShipperCode'];
            $Traces         = $Datalist['Traces'];
            $State          = $Datalist['State'];

            $HubExpressLog = new HubExpressLog();
            $HubExpressLog->deleteAll(['LogisticCode'=>$LogisticCode]);
            if(!empty($Traces) && is_array($Traces)){
                foreach ($Traces as $key => $value) {
                    $_HubExpressLog = new $HubExpressLog;
                    $data = [
                        'Action'        =>$value['Action'],
                        'ShipperCode'=>$ShipperCode,
                        'LogisticCode'=>$LogisticCode,
                        'Location'=>$value['Location'],
                        'AcceptStation'=>$value['AcceptStation'],
                        'AcceptTime'=>StringHelper::dateToInt($value['AcceptTime']),
                        'Remark'=>$value['Remark'],
                        'EstimatedDeliveryTime'=>'',
                        'State'=>$State,
                        'EBusinessID'=> $EBusinessID,
                    ];
                    
                    loggingHelper::writeLog('diandi_hub', 'KdApiService/saveKdninfo', '快递信息存储',$data);
    
                    $_HubExpressLog->setAttributes($data);
                    if(!$_HubExpressLog->save()){
                       
                        $msg = ErrorsHelper::getModelError($_HubExpressLog);
                        
                        loggingHelper::writeLog('diandi_hub', 'KdApiService/saveKdninfo', '快递信息存储错误',$msg);
                        
                    }
                    
                }
            }
        }
     
    }

    public static function list($member_id,$order_no)
    {
        $HubExpressLog = new HubExpressLog();
        
        $Expressinfo = HubOrder::find()->where(['order_no'=>$order_no,'user_id'=>$member_id])->select(['express_company', 'express_no'])->one();

        if(!empty($Expressinfo)){
            $ShipperCode  = $Expressinfo['express_company'];
        
            $LogisticCode = $Expressinfo['express_no'];
            
            $list = $HubExpressLog->find()->where([
                'ShipperCode'=>$ShipperCode,
                'LogisticCode'=>$LogisticCode
                ])->orderBy(['AcceptTime'=>SORT_DESC])->asArray()->all();
            
            if(empty($list)){
                return [
                    'status'=>1,
                    'msg'=>'暂时没有快递信息，请稍后查询'
                ];   
            }else{
                foreach ($list as $key => &$value) {
                    
                    $value['AcceptTime'] = StringHelper::intToDate($value['AcceptTime']);
                
                }
                
                //根据公司业务处理返回的信息......
                $express_company = HubExpressCompany::find()->where(['status'=>1,'code'=>$ShipperCode])->select('title')->scalar();
                
                return [
                    'status'=>0,
                    'msg'=>'快递信息查询成功',
                    'list'=>$list,
                    'express_company'=>$express_company,
                ];
            }
               
        }else{
            return [
                'status'=>1,
                'msg'=>'该订单不存在'
            ];  
        }

    }

    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    public static function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
} 






?>