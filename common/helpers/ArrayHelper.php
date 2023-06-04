<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 09:53:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-04 12:56:30
 */

namespace common\helpers;

use yii\helpers\BaseArrayHelper;
use yii\helpers\Json;

/**
 * Class ArrayHelper.
 *
 * @author chunchun <2192138785@qq.com>
 */
class ArrayHelper extends BaseArrayHelper
{
    /**
     * 递归数组.
     *
     * @param string $idField
     * @param int    $pid
     * @param string $pidField
     *
     * @return array
     */
    public static function itemsMerge(array $items, $pid = 0, $idField = 'id', $pidField = 'pid', $child = '-', $level = 1)
    {
        $arr = [];
        foreach ($items as $v) {
            if ($v[$pidField] == $pid) {
                $v['level'] = $level;
                $childData = self::itemsMerge($items, $v[$idField], $idField, $pidField, $child, $level + 1);
                if (!empty($childData)) {
                    $v[$child] = $childData;
                }
                $arr[] = $v;
            }
        }

        return $arr;
    }

    /**
     * 传递一个子分类ID返回所有的父级分类.
     *
     * @param $id
     *
     * @return array
     */
    public static function getParents(array $items, $id)
    {
        $arr = [];
        foreach ($items as $v) {
            if ($v['id'] == $id) {
                $arr[] = $v;
                $arr = array_merge(self::getParents($items, $v['pid']), $arr);
            }
        }

        return $arr;
    }

    /**
     * 传递一个父级分类ID返回所有子分类.
     *
     * @param $cate
     * @param int $pid
     *
     * @return array
     */
    public static function getChilds($cate, $pid)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $arr[] = $v;
                $arr = array_merge($arr, self::getChilds($cate, $v['id']));
            }
        }

        return $arr;
    }

    /**
     * 传递一个父级分类ID返回所有子分类ID.
     *
     * @param $cate
     * @param $pid
     * @param string $idField
     * @param string $pidField
     *
     * @return array
     */
    public static function getChildIds($cate, $pid, $idField = 'id', $pidField = 'pid')
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v[$pidField] == $pid) {
                $arr[] = $v[$idField];
                $arr = array_merge($arr, self::getChildIds($cate, $v[$idField], $idField, $pidField));
            }
        }

        return $arr;
    }

    /**
     * php二维数组排序 按照指定的key 对数组进行排序.
     *
     * @param array  $arr  将要排序的数组
     * @param string $keys 指定排序的key
     * @param string $type 排序类型 asc | desc
     *
     * @return array
     */
    public static function arraySort($arr, $keys, $type = 'asc')
    {
        if (count($arr) <= 1) {
            return $arr;
        }

        $keysValue = [];
        $newArray = [];

        foreach ($arr as $k => $v) {
            $keysValue[$k] = $v[$keys];
        }

        $type == 'asc' ? asort($keysValue) : arsort($keysValue);
        reset($keysValue);

        foreach ($keysValue as $k => $v) {
            $newArray[$k] = $arr[$k];
        }

        return array_values($newArray);
    }

    /**
     * 获取数组指定的字段为key.
     *
     * @param array  $arr   数组
     * @param string $field 要成为key的字段名
     *
     * @return array
     */
    public static function arrayKey(array $arr, $field)
    {
        $newArray = [];
        foreach ($arr as $value) {
            isset($value[$field]) && $newArray[$value[$field]] = $value;
        }

        return $newArray;
    }

    /**
     * 获取数组指定的字段为key.
     *
     * @param array  $arr   数组
     * @param string $field 要成为key的字段名
     *
     * @return array
     */
    public static function arrayKeys(array $arr, $field)
    {
        $newArray = [];
        foreach ($arr as $value) {
            isset($value[$field]) && $newArray[$value[$field]][] = $value;
        }

        return $newArray;
    }

    /**
     * 移除数组内某个key的值为传递的值
     *
     * @param $value
     * @param string $key
     *
     * @return array
     */
    public static function removeByValue(array $array, $value, $key = 'id')
    {
        foreach ($array as $index => $item) {
            if ($item[$key] == $value) {
                unset($array[$index]);
            }
        }

        return $array;
    }

    /**
     * 移除数组内某个key.
     *
     * @param array  $array
     * @param string $key
     *
     * @return array
     */
    public static function removeByKey(&$array, $key = 'id')
    {
        foreach ($array as $index => &$item) {
            unset($item[$key]);
            if (!empty($item['child'])) {
                self::removeByKey($item['child'], $key);
            }
        }

        return $array;
    }

    /**
     * 获取数字区间.
     *
     * @param int $start
     * @param int $end
     *
     * @return array
     */
    public static function numBetween($start = 0, $end = 1, $key = true)
    {
        $arr = [];
        for ($i = $start; $i <= $end; ++$i) {
            $key == true ? $arr[$i] = $i : $arr[] = $i;
        }

        return $arr;
    }

    /**
     * 根据级别和数组返回字符串.
     *
     * @param int $level 级别
     * @param $k
     * @param int $treeStat 开始计算
     *
     * @return bool|string
     */
    public static function itemsLevel($level, array $models, $k, $treeStat = 1)
    {
        $str = '';
        for ($i = 1; $i < $level; ++$i) {
            $str .= '　　';

            if ($i == $level - $treeStat) {
                if (isset($models[$k + 1])) {
                    return $str.'├──';
                }

                return $str.'└──';
            }
        }

        return false;
    }

    /**
     * 必须经过递归才能进行重组为下拉框.
     *
     * @param $models
     * @param string $idField
     * @param string $titleField
     * @param int    $treeStat
     *
     * @return array
     */
    public static function itemsMergeDropDown($models, $idField = 'id', $titleField = 'title', $treeStat = 1)
    {
        $arr = [];
        foreach ($models as $k => $model) {
            $arr[] = [
                $idField => $model[$idField],
                $titleField => self::itemsLevel($model['level'], $models, $k, $treeStat).' '.$model[$titleField],
            ];

            if (!empty($model['-'])) {
                $arr = ArrayHelper::merge($arr, self::itemsMergeDropDown($model['-'], $idField, $titleField, $treeStat));
            }
        }

        return $arr;
    }

    /**
     * 匹配ip在ip数组内支持通配符.
     *
     * @param $ip
     * @param $allowedIPs
     *
     * @return bool
     */
    public static function ipInArray($ip, $allowedIPs)
    {
        foreach ($allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取递归的第一个没有子级的数据.
     *
     * @param $array
     *
     * @return mixed
     */
    public static function getFirstRowByItemsMerge(array $array)
    {
        foreach ($array as $item) {
            if (!empty($item['-'])) {
                return self::getFirstRowByItemsMerge($item['-']);
            } else {
                return $item;
            }
        }

        return false;
    }

    /**
     * 获取所有没有子级的数据.
     *
     * @param $array
     *
     * @return mixed
     */
    public static function getNotChildRowsByItemsMerge(array $array)
    {
        $arr = [];

        foreach ($array as $item) {
            if (!empty($item['-'])) {
                $arr = array_merge($arr, self::getNotChildRowsByItemsMerge($item['-']));
            } else {
                $arr[] = $item;
            }
        }

        return $arr;
    }

    /**
     * 递归转普通二维数组.
     *
     * @param $array
     *
     * @return mixed
     */
    public static function getRowsByItemsMerge(array $array, $childField = '-')
    {
        $arr = [];

        foreach ($array as $item) {
            if (!empty($item[$childField])) {
                $arr = array_merge($arr, self::getRowsByItemsMerge($item[$childField]));
            }

            unset($item[$childField]);
            $arr[] = $item;
        }

        return $arr;
    }

    /**
     * 重组 map 类型转为正常的数组.
     *
     * @param array  $array
     * @param string $keyForField
     * @param string $valueForField
     *
     * @return array
     */
    public static function regroupMapToArr($array = [], $keyForField = 'route', $valueForField = 'title')
    {
        $arr = [];
        foreach ($array as $key => $item) {
            if (!is_array($array[$key])) {
                $arr[] = [
                    $keyForField => $key,
                    $valueForField => $item,
                ];
            } else {
                $arr[] = $item;
            }
        }

        return $arr;
    }

    /**
     * 数组内某字段转数组.
     *
     * @param string $field
     *
     * @return array
     */
    public static function fieldToArray(array $data, $field = 'covers')
    {
        foreach ($data as &$datum) {
            if (empty($datum[$field])) {
                $datum[$field] = [];
            }

            if (!is_array($datum[$field])) {
                $datum[$field] = Json::decode($datum[$field]);
            }
        }

        return $data;
    }

    /**
     * @desc 对象转化为数组
     *
     * @return array
     */
    public static function objectToarray(&$object)
    {
        if (is_object($object)) {
            $arr = (array) ($object);
        } else {
            $arr = &$object;
        }
        if (is_array($arr)) {
            foreach ($arr as $varName => $varValue) {
                $arr[$varName] = self::objectToarray($varValue);
            }
        }

        return $arr;
    }

    /**
     * 数组转xml.
     *
     * @param $arr
     * 微信回调成功：['return_code' => 'SUCCESS', 'return_msg' => 'OK']
     * 微信回调失败：['return_code' => 'FAIL', 'return_msg' => 'OK']
     *
     * @return bool|string
     */
    public static function toXml($arr)
    {
        if (!is_array($arr) || count($arr) == 0) {
            return false;
        }

        $xml = '<xml>';
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= '<'.$key.'>'.$val.'</'.$key.'>';
            } else {
                $xml .= '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
            }
        }

        $xml .= '</xml>';

        return $xml;
    }

    public static function array2xml($arr, $level = 1)
    {
        $s = 1 == $level ? '<xml>' : '';
        foreach ($arr as $tagname => $value) {
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if (!is_array($value)) {
                if (strpos($tagname, '-') !== false) {
                    list($tagname, $num) = explode('-', $tagname);
                }
                $s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
            } else {
                $s .= "<{$tagname}>".self::array2xml($value, $level + 1)."</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);

        return 1 == $level ? $s.'</xml>' : $s;
    }

    public static function xml2array($xml)
    {
        if (empty($xml)) {
            return [];
        }
        $result = [];
        $xmlobj = isimplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xmlobj instanceof SimpleXMLElement) {
            $result = json_decode(json_encode($xmlobj), true);
            if (is_array($result)) {
                return $result;
            } else {
                return '';
            }
        } else {
            return $result;
        }
    }
}
