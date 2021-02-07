<?php

if (!function_exists('route_class')) {
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

//随机验证码
if (!function_exists('smsCode')) {
    function smsCode()
    {
        //生成4位随机数，左侧补0
        return str_pad(random_int(1111, 9999), 4, 0, STR_PAD_LEFT);
    }
}

if (!function_exists('qiNiu')) {
    function qiNiu()
    {
        return 'http://' . config('filesystems.disks.qiniu.domains.default') . '/';
    }
}

if (!function_exists('sub')) {
    function sub($str)
    {
        return false === mb_strpos($str, '/') ? $str : mb_substr($str, 0, mb_strrpos($str, '/'));
    }
}

if (!function_exists('isPro')) {
    function isPro()
    {
        return 'production' === env('APP_ENV') ? true : false;
    }
}

/**
 * [gbk和utf8编码自动识别方法[](https://www.bo56.com/gbk%E5%92%8Cutf8%E7%BC%96%E7%A0%81%E8%87%AA%E5%8A%A8%E8%AF%86%E5%88%AB%E6%96%B9%E6%B3%95php%E7%89%88/).
 *
 * @param $str
 * @param string $encoding
 */
function detectEncoding($str, $encoding = 'utf8'): string
{
    $len = mb_strlen($str);
    $is_utf8_chinese = false;

    //判断gbk的各种情况；除了gbk8和gbk9
    for ($i = 0; $i < $len; ++$i) {
        if ((ord($str[$i]) >> 7) > 0) { //非ascii字符
            if (ord($str[$i]) <= 191) {
                $encoding = 'gbk0';
                break;
            } elseif (ord($str[$i]) <= 223) { //前两位为11
                if (empty($str[$i + 1]) or 2 != ord($str[$i + 1]) >> 6) { //紧跟后两位为10
                    $encoding = 'gbk1';
                    break;
                }
                ++$i;
            } elseif (ord($str[$i]) <= 239) { //前三位为111
                if (empty($str[$i + 1]) or 2 != ord($str[$i + 1]) >> 6 or empty($str[$i + 2]) or 2 != ord($str[$i + 2]) >> 6) { //紧跟后两位为10
                    $encoding = 'gbk2';
                    break;
                }
                $i += 2;
                $is_utf8_chinese = true;
            } elseif (ord($str[$i]) <= 247) { //前四位为1111
                if (empty($str[$i + 1]) or 2 != ord($str[$i + 1]) >> 6 or empty($str[$i + 2]) or 2 != ord($str[$i + 2]) >> 6 or empty($str[$i + 3]) or 2 != ord($str[$i + 3]) >> 6) { //紧跟后两位为10
                    $encoding = 'gbk3';
                    break;
                }
                $i += 3;
            } elseif (ord($str[$i]) <= 251) { //前五位为11111
                if (empty($str[$i + 1]) or 2 != ord($str[$i + 1]) >> 6 or empty($str[$i + 2]) or 2 != ord($str[$i + 2]) >> 6 or empty($str[$i + 3]) or 2 != ord($str[$i + 3]) >> 6 or empty($str[$i + 4]) or 2 != ord($str[$i + 4]) >> 6) { //紧跟后两位为10
                    $encoding = 'gbk4';
                    break;
                }
                $i += 4;
            } elseif (ord($str[$i]) <= 253) { //前六位为111111
                if (empty($str[$i + 1]) or 2 != ord($str[$i + 1]) >> 6 or empty($str[$i + 2]) or 2 != ord($str[$i + 2]) >> 6 or empty($str[$i + 3]) or 2 != ord($str[$i + 3]) >> 6 or empty($str[$i + 4]) or 2 != ord($str[$i + 4]) >> 6 or empty($str[$i + 5]) or 2 != ord($str[$i + 5]) >> 6) { //紧跟后两位为10
                    $encoding = 'gbk5';
                    break;
                }
                $i += 5;
            } else {
                $encoding = 'gbk6';
                break;
            }
        }
    }

    //gbk的各种情况的判断；gbk10, gbk7,
    if (false == $is_utf8_chinese) {
        $encoding = 'gbk10';
    }
    if ('utf8' == $encoding
        && preg_match('/^[' . chr(0xa1) . '-' . chr(0xff) . "\x20-\x7f]+$/", $str)
        && !preg_match(
            "/^[\x{4e00}-\x{9fa5}\x20-\x7f]+$/u",
            $str
        )) {
        $encoding = 'gbk7';
    }

    return $encoding;
}

if (!function_exists('getDomain')) {
    function getDomain()
    {
        $urlArr = parse_url(\Illuminate\Support\Facades\URL::current());

        return $urlArr['scheme'] . '://' . $urlArr['host'];
    }
}
