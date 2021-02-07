<?php

use Carbon\Carbon;

if (!function_exists('beforeNowFormat')) {
    // $type是年月日分钟
    function beforeNowFormat(string $type = 'day', string $time = '1', string $format = 'Y-m-d')
    {
        if ('year' == $type) {
            return Carbon::now()->subYears($time)->format($format);
        }
        if ('month' == $type) {
            return Carbon::now()->subMonths($time)->format($format);
        }

        if ('minute' == $type) {
            return Carbon::now()->subMinutes($time)->format($format);
        }

        // 默认type=day
        return Carbon::now()->subDays($time)->format($format);
    }
}

if (!function_exists('beforeNowTimestamp')) {
    // $type是年月日分钟
    // $format = 'Y-m-d H:i:s'
    function beforeNowTimestamp(string $type = 'day', string $time = '1')
    {
        if ('year' == $type) {
            return Carbon::now()->subYears($time)->timestamp;
        }
        if ('month' == $type) {
            return Carbon::now()->subMonths($time)->timestamp;
        }

        if ('minute' == $type) {
            return Carbon::now()->subMinutes($time)->timestamp;
        }

        // 默认type=day，time=1，则为昨天的时间戳
        return Carbon::now()->subDays($time)->timestamp;
    }
}

if (!function_exists('afterNowFormat')) {
    // $type是年月日分钟
    // $format = 'Y-m-d H:i:s'
    function afterNowFormat(string $type = 'day', string $time = '1', string $format = 'Y-m-d')
    {
        if ('year' == $type) {
            return Carbon::now()->addYears($time)->format($format);
        }
        if ('month' == $type) {
            return Carbon::now()->addMonths($time)->format($format);
        }

        if ('minute' == $type) {
            return Carbon::now()->addMinutes($time)->format($format);
        }

        // 默认type=day
        return Carbon::now()->addDays($time)->format($format);
    }
}

if (!function_exists('afterNowTimestamp')) {
    // $type是年月日分钟
    // $format = 'Y-m-d H:i:s'
    function afterNowTimestamp(string $type = 'day', string $time = '1')
    {
        if ('year' == $type) {
            return Carbon::now()->addYears($time)->timestamp;
        }
        if ('month' == $type) {
            return Carbon::now()->addMonths($time)->timestamp;
        }

        if ('minute' == $type) {
            return Carbon::now()->addMinutes($time)->timestamp;
        }

        // 默认type=day
        return Carbon::now()->addDays($time)->timestamp;
    }
}

if (!function_exists('afterDaysFormat')) {
    function afterDaysFormat($time, $num)
    {
        return \Carbon\Carbon::parse($time)->addDays($num)->format('Y-m-d H:i:s');
    }
}

if (!function_exists('beforeDaysFormatList')) {
    /**
     * 列出之前n天的格式化时间，返回数组.
     */
    function beforeDaysFormatList(string $days, string $prefix = ''): array
    {
        $dayArr = [];
        for ($i = 0; $i < $days; ++$i) {
            $dayArr[$i] = $prefix . beforeNowFormat('day', $i);
        }

        return $dayArr;
    }
}

if (!function_exists('nowFormat')) {
    function nowFormat()
    {
        return \Carbon\Carbon::now()->format('Y-m-d H:i:s');
    }
}

//当前的时间戳 1559293545
if (!function_exists('nowTimestamp')) {
    function nowTimestamp()
    {
        return \Carbon\Carbon::now()->timestamp;
    }
}

// 今天的时间戳
if (!function_exists('todayTimestamp')) {
    function todayTimestamp()
    {
        return \Carbon\Carbon::today()->timestamp;
    }
}

//今天；"2019-05-31"
if (!function_exists('todayDate')) {
    function todayDate()
    {
        return date('Y-m-d', time());
    }
}

////今天
/// Illuminate\Support\Carbon @1578240000 {#484
//  date: 2020-01-06 00:00:00.0 Asia/shanghai (+08:00)
//}
//if (!function_exists('today')) {
//    function today()
//    {
//        $dt = \Carbon\Carbon::now();
//        $dt->timezone = 'PRC';
//
//        return $dt->today()->toDateString();
//    }
//}

// 通过年月日，获取该用户生日
if (!function_exists('getAge')) {
    function getAge(string $birthday)
    {
        list($birthYear, $birthMonth, $birthDay) = explode('-', $birthday);
        list($currentYear, $currentMonth, $currentDay) = explode('-', date('Y-m-d'));
        $age = $currentYear - $birthYear - 1;
        if ($currentMonth > $birthMonth || $currentMonth == $birthMonth && $currentDay >= $birthDay) {
            ++$age;
        }

        return $age;
    }
}

// 转为可读性更高的时间
if (!function_exists('transTime')) {
    function transTime($date)
    {
        \Carbon\Carbon::setLocale('zh');

        return \Carbon\Carbon::parse($date)->diffForHumans();
    }
}

if (!function_exists('getDiffTime')) {
    function getDiffTime($date)
    {
        $time = strtotime($date);
        if (!$time || $time < time()) {
            return false;
        }

        $now = Carbon::now();
        $seconds = $now->diffInSeconds(Carbon::createFromTimestamp($time));

        return $seconds;
    }
}
