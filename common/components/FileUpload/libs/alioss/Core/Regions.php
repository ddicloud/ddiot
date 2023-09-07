<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:14:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-05 17:01:31
 */

namespace Alioss\Core;

/**
 * Class Regions.
 *
 * 公共云下OSS Region和Endpoint对照表
 */
class Regions
{
    /**
     * 根据文件名，获取http协议header中的content-type应该填写的数据.
     *
     * @param string $name 缺省名
     *
     * @return string|null content-type
     */
    public static function getRegionEnd(string $name): ?string
    {
        if (isset(self::$region_end_point[$name])) {
            return self::$region_end_point[$name];
        }
        
        return null;
    }

    private static array $region_end_point = [
         'oss-cn-hangzhou' => '华东1（杭州）',
         'oss-cn-shanghai' => '华东2（上海）',
         'oss-cn-qingdao' => '华北1（青岛）',
         'oss-cn-beijing' => '华北2（北京）',
         'oss-cn-zhangjiakou' => '华北3（张家口）',
         'oss-cn-huhehaote' => '华北5（呼和浩特）',
         'oss-cn-wulanchabu' => '华北6（乌兰察布）',
         'oss-cn-shenzhen' => '华南1（深圳）',
         'oss-cn-heyuan' => '华南2（河源）',
         'oss-cn-guangzhou' => '华南3（广州）',
         'oss-cn-chengdu' => '西南1（成都）',
         'oss-cn-hongkong' => '中国（香港）',
         'oss-us-west-1' => '美国（硅谷）*',
         'oss-us-east-1' => '美国（弗吉尼亚）*',
         'oss-ap-southeast-1' => '新加坡*',
         'oss-ap-southeast-2' => '澳大利亚（悉尼）*',
         'oss-ap-southeast-3' => '马来西亚（吉隆坡）*',
         'oss-ap-southeast-5' => '印度尼西亚（雅加达）*',
         'oss-ap-northeast-1' => '日本（东京）*',
         'oss-ap-south-1' => '印度（孟买）*',
         'oss-eu-central-1' => '德国（法兰克福）*',
         'oss-eu-west-1' => '英国（伦敦）',
         'oss-me-east-1' => '阿联酋（迪拜）*',
         'oss-ap-southeast-6' => '菲律宾（马尼拉）'
    ];
}