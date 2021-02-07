<?php

if (!function_exists('arrayInsert')) {
    function arrayInsert(&$arr, $position, $insertArr)
    {
        $first_array = array_splice($arr, 0, $position);
        $arr = array_merge($first_array, $insertArr, $arr);

        return $arr;
    }
}

/*
 * 用array_reduce()实现二维转一维；.
 *
 * array_merge把相同字符串键名的数组覆盖合并，所以必须先用array_value取出值后，再合并；
 *
 * @param array $items
 *
 * @return array
 */
if (!function_exists('tda2oda')) {
    function tda2oda(array $items): array
    {
        $result = array_reduce($items, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, []);

        return $result;
    }
}

if (!function_exists('mda2oda')) {
    function mda2oda(array $items): array
    {
        $result = [];
        array_walk_recursive($items, function ($value) use (&$result) {
            array_push($result, $value);
        });

        return $result;
    }
}

/*
 * 取出关联数组的相邻元素.
 *
 * @param $array
 *
 * @return array
 */
if (!function_exists('currentAndNext')) {
    function currentAndNext($array): array
    {
        while ($current = current($array)) {
            $next = next($array);

            if (false != $next) {
                return [$current, $next];
            }
        }
    }
}

// 去重数组中的重复元素，支付二维数组，array_unique()只支持一维数组
function arrUnique($array)
{
    sort($array);
    $tem = '';
    $temarray = [];
    $j = 0;
    for ($i = 0; $i < count($array); ++$i) {
        if ($array[$i] != $tem) {
            $temarray[$j] = $array[$i];
            ++$j;
        }
        $tem = $array[$i];
    }

    return $temarray;
}

/**
 * 删除数组中的指定元素.
 *
 * @param $arr
 * @param $element
 */
function arrayRemoveElement(&$arr, $element): array
{
    if (in_array($element, $arr)) {
        array_splice($arr, array_search($element, $arr), 1);
    }

    return $arr;
}

// 二维数组转字符串
function tdaToString(array $arr): string
{
    if (is_array($arr)) {
        return implode(',', array_map('tdaToString', $arr));
    }

    return '';
}

if (!function_exists('arrRandVal')) {
    function arrRandVal(array $arr)
    {
        return $arr[array_rand($arr)];
    }
}

if (!function_exists('delByValue')) {
    function delByValue($arr, $value): array
    {
        if (!is_array($arr)) {
            return $arr;
        }
        foreach ($arr as $key => $val) {
            foreach ($val as $k => $v) {
                if ($v == $value) {
                    unset($arr[$key]);
                }
            }
        }

        return $arr;
    }
}

if (!function_exists('jsonEncode')) {
    function jsonEncode(array $arr): string
    {
        return json_encode($arr);
    }
}

if (!function_exists('jsonDecode')) {
    function jsonDecode(string $str): array
    {
        return json_decode($str);
    }
}

if (!function_exists('arrayInsert')) {
    function arrayInsert(&$arr, $position, $insertArr)
    {
        $first_array = array_splice($arr, 0, $position);
        $arr = array_merge($first_array, $insertArr, $arr);

        return $arr;
    }
}

if (!function_exists('tda2oda')) {
    /**
     * 用array_reduce()实现二维转一维；.
     *
     * array_merge把相同字符串键名的数组覆盖合并，所以必须先用array_value取出值后，再合并；
     */
    function tda2oda(array $items): array
    {
        $result = array_reduce($items, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, []);

        return $result;
    }
}

// 多维数组转一维数组
if (!function_exists('mda2oda')) {
    function mda2oda(array $items): array
    {
        $result = [];
        array_walk_recursive($items, function ($value) use (&$result) {
            array_push($result, $value);
        });

        return $result;
    }
}

if (!function_exists('currentAndNext')) {
    /**
     * 取出关联数组的相邻元素.
     *
     * @param $array
     */
    function currentAndNext($array): array
    {
        while ($current = current($array)) {
            $next = next($array);

            if (false != $next) {
                return [$current, $next];
            }
        }
    }
}

if (!function_exists('arrRandVal')) {
    function arrRandVal(array $arr)
    {
        return $arr[array_rand($arr)];
    }
}

if (!function_exists('delByValue')) {
    function delByValue($arr, $value): array
    {
        if (!is_array($arr)) {
            return $arr;
        }
        foreach ($arr as $key => $val) {
            foreach ($val as $k => $v) {
                if ($v == $value) {
                    unset($arr[$key]);
                }
            }
        }

        return $arr;
    }
}

if (!function_exists('jsonEncode')) {
    function jsonEncode(array $arr): string
    {
        return json_encode($arr);
    }
}

if (!function_exists('arrayToString')) {
    function arrayToString($arr)
    {
        if (is_array($arr)) {
            return implode(',', array_map('arrayToString', $arr));
        }

        return $arr;
    }
}

// 合并多维数组里相同的key
if (!function_exists('combineSameKey')) {
    function combineSameKey($array, $combineKey)
    {
        $result = [];
        foreach ($array as $key => $info) {
            $result[$info[$combineKey]] = $info;
        }

        return $result;
    }
}

if (!function_exists('cvtJsToArr')) {
    function cvtJsToArr(string $json)
    {
        return json_decode($json, true);
    }
}

// 随机合并数组、并保持原排序
//[[算法]PHP随机合并数组并保持原排序 - 韭白 - 博客园](https://www.cnblogs.com/shockerli/p/shuffle-merge-array.html)
if (!function_exists('shuffleMergeArray')) {
    function shuffleMergeArray($array1, $array2)
    {
        $mergeArray = [];
        $sum = count($array1) + count($array2);
        for ($k = $sum; $k > 0; --$k) {
            $number = mt_rand(1, 2);
            if (1 == $number) {
                $mergeArray[] = $array2 ? array_shift($array2) : array_shift($array1);
            } else {
                $mergeArray[] = $array1 ? array_shift($array1) : array_shift($array2);
            }
        }

        return $mergeArray;
    }
}

/**
 *  二维数组去除重复值
 *
 * 用array_map()重构了一下，为什么use要引入的变量是作为入参的$key，而不是声明的$res；
 *
 * @param $arr
 * @param $key
 *
 * @return array
 */
function arrayUnset($arr, $key)
{
    //建立一个目标数组
    $res = [];
    array_map(function ($value) use (&$key) {
        //查看是否有重复值
        if (isset($res[$value[$key]])) {
            //如果重复则销毁；
            unset($value[$key]);
        } else {
            $res[$value[$key]] = $value;
        }
    }, $arr);

    return $res;
}

/**
 * 对二维数组按照 title+pubscore 去重.
 *
 * @param $arr
 * @param $key1
 * @param $key2
 *
 * @return mixed
 */
function uniqueByKey($arr, $key1, $key2)
{
    $tmp_key = [];
    foreach ($arr as $key => $item) {
        if (in_array($item[$key1] . $item[$key2], $tmp_key)) {
            unset($arr[$key]);
        } else {
            $tmp_key[] = $item[$key1] . $item[$key2];
        }
    }

    return $arr;
}

/**
 * 怎么根据2个数组id相同的一维数组，将$arr2的shop_name添加到$arr，如果没有相同的id，shop_name为空，形成如下数组$resArr
 * todo	跑起来有问题；.
 *
 * @see [php将两个数组相同的key合并到一个数组 - SegmentFault 思否](https://segmentfault.com/q/1010000000477066)
 */
function combineArr($arr1, $arr2)
{
    $tempArr = [];

    foreach ($arr1 as $k => $v) {
        if (array_key_exists($v['id'], $tempArr)) {
            $arr[$k]['shop_name'] = $tempArr[$v['id']];
        } else {
            $arr[$k]['shop_name'] = '';
        }
    }

    foreach ($arr2 as $item) {
        $tempArr[$item['id']] = $item['shop_name'];
    }

    $resArr = $arr;

    return $resArr;
}

/**
 * @see https://blog.csdn.net/fdipzone/article/details/78070334
 *
 * 将多个一维数组合拼成二维数组（使用的时候，注意$key的使用；）
 *
 * @param array $keys 定义新二维数组的键值，每个对应一个一维数组
 * @param array $args 多个一维数组集合
 *
 * @return array
 */
function array_merge_more($keys, ...$arrs)
{

    // 检查参数是否正确
    if (!$keys || !is_array($keys) || !$arrs || !is_array($arrs) || count($keys) != count($arrs)) {
        return [];
    }

    // 一维数组中最大长度
    $max_len = 0;

    // 整理数据，把所有一维数组转重新索引
    for ($i = 0,$len = count($arrs); $i < $len; ++$i) {
        $arrs[$i] = array_values($arrs[$i]);

        if (count($arrs[$i]) > $max_len) {
            $max_len = count($arrs[$i]);
        }
    }

    // 合拼数据
    $result = [];

    for ($i = 0; $i < $max_len; ++$i) {
        $tmp = [];
        foreach ($keys as $k => $v) {
            if (isset($arrs[$k][$i])) {
                $tmp[$v] = $arrs[$k][$i];
            }
        }
        $result[] = $tmp;
    }

    return $result;
}

/**
 * 多维转二维.
 *
 * [PHP多维数组转换成二维数组 - SegmentFault](https://segmentfault.com/q/1010000004083783)
 * [PHP二维数组排序的3种方法和自定义函数分享_php实例_脚本之家](http://www.jb51.net/article/48841.htm)
 */
function reformat($arrTmp, $parent_id = 0, &$ret = null)
{
    foreach ($arrTmp as $k => $v) {
        $ret[$v['id']] = ['id' => $v['id'], 'level' => $v['level'], 'parent_id' => $parent_id];
        if ($v['child']) {
            reformat($v['child'], $v['id'], $ret);
        }
    }

    return $ret;
}

/**
 * 深度转化；使用array_walk_recursive()
 * 任何多维数组都能转一维数组；.
 *
 * [PHP二维数组（或任意维数组）转换成一维数组的方法汇总 - 歪麦博客](https://www.awaimai.com/2064.html)
 */
function deepFlatten($items)
{
    $result = [];
    array_walk_recursive($items, function ($value) use (&$result) {
        array_push($result, $value);
    });

    return $result;
}

/**
 * 用array_map()实现二维转一维；.
 *
 * array_map
 */
function mapFlatten($items)
{
    $result = [];
    array_map(function ($value) use (&$result) {
        $result = array_merge($result, array_values($value));
    }, $items);

    return $result;
}
