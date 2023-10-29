<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 11:55:58
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\HubGoodsOrderLog;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\order\HubOrderLog;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\WithdrawTypeStatus;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;

/**
 * Class AddressController.
 */
class HubService extends BaseService
{
    public $modelClass = '\common\models\Member';
    
    /**
     * 根据操作类型返回提现要操作的字段
     * @param [type] $WithdrawTyp
     * @param [type] $action_type   申请提现，驳回提现，
     * @return void
     */ 
    public static function getFiledsByWithdrawType($WithdrawTyp,$action_type)
    {
        $fileds = [];

        switch ($WithdrawTyp) {
            case WithdrawTypeStatus::getValueByName('用户'):
                $fileds = [
                    
                ];               
                
                break;
            case WithdrawTypeStatus::getValueByName('团队'):
                $fileds = [
                    
                ];  

                break;
                
            case WithdrawTypeStatus::getValueByName('店铺'):
                $fileds = [
                    
                ];  
                break;
                
            case WithdrawTypeStatus::getValueByName('代理'):
                $fileds = [
                    
                ];  
                break;
        
        }
    }


    public static function getFiledsByType($account_type)
    {
        $fileds = '';
        switch ($account_type) {
            case AccountTypeStatus::getValueByName('团豆'):
                $fileds = '';
                
                break;
        
            case AccountTypeStatus::getValueByName('余额'):
                $fileds = '';

            break;

            case AccountTypeStatus::getValueByName('金库'):
                $fileds = '';

            break;

            case AccountTypeStatus::getValueByName('分享可提现'):
                $fileds = 'self_money';

            break;

            case AccountTypeStatus::getValueByName('分享待发放'):
                $fileds = 'self_freeze';

            break;

            case AccountTypeStatus::getValueByName('分享已提现'):
                $fileds = 'self_withdraw';

            break;
            case AccountTypeStatus::getValueByName('分享已提现'):
                $fileds = '';

            break;

            case AccountTypeStatus::getValueByName('团队可提现'):
                $fileds = 'team_money';

            break;

            case AccountTypeStatus::getValueByName('团队待发放'):
                $fileds = 'team_freeze';

            break;

            case AccountTypeStatus::getValueByName('团队已提现'):
                $fileds = 'team_withdraw';

            break;

            case AccountTypeStatus::getValueByName('店铺可提现'):
                $fileds = 'store_money';

            break;

            case AccountTypeStatus::getValueByName('店铺待发放'):
                $fileds = 'store_freeze';

            break;

            case AccountTypeStatus::getValueByName('店铺已提现'):
                $fileds = 'store_withdraw';

            break;
            case AccountTypeStatus::getValueByName('代理可提现'):
                $fileds = 'agent_money';

            break;
            case AccountTypeStatus::getValueByName('代理已提现'):
                $fileds = 'agent_withdraw';

            break;
            case AccountTypeStatus::getValueByName('代理待发放'):
                $fileds = 'agent_freeze';

            break;
            case AccountTypeStatus::getValueByName('流水奖金已提现'):
                $fileds = 'water_withdraw';
            break;
            case AccountTypeStatus::getValueByName('流水奖金待发放'):
                $fileds = 'water_freeze';

            break;
            case AccountTypeStatus::getValueByName('流水奖金可提现'):
                $fileds = 'water_money';

            break;

        }

        return $fileds;
    }
}
?>
