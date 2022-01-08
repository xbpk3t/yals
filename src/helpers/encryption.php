<?php

function rc4($data, $pwd)//　$data需加密字符串  $pwd密钥
{
    $key[] = '';
    $box[] = '';

    $pwd_length = mb_strlen($pwd);
    $data_length = mb_strlen($data);
    $cipher = '';

    for ($i = 0; $i < 256; ++$i) {
        $key[$i] = ord($pwd[$i % $pwd_length]);
        $box[$i] = $i;
    }

    for ($j = $i = 0; $i < 256; ++$i) {
        $j = ($j + $box[$i] + $key[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $data_length; ++$i) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;

        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;

        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipher .= chr(ord($data[$i]) ^ $k);
    }

    return $cipher;
}

/**
 * @url https://blog.csdn.net/sexy_it/article/details/23174915
 *
 * @param $str
 *
 * @return string
 */
function jsEscape($str)
{
    preg_match_all("/[\xc2-\xdf][\x80-\xbf]+|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}|[\x01-\x7f]+/e", $str, $r);
    //匹配utf-8字符，
    $str = $r[0];
    $l = count($str);
    for ($i = 0; $i < $l; ++$i) {
        $value = ord($str[$i][0]);
        if ($value < 223) {
            $str[$i] = rawurlencode(utf8_decode($str[$i]));
        //先将utf8编码转换为ISO-8859-1编码的单字节字符，urlencode单字节字符.
//utf8_decode()的作用相当于iconv("UTF-8","CP1252",$v)。
        } else {
            $str[$i] = '%u' . mb_strtoupper(bin2hex(iconv('UTF-8', 'UCS-2', $str[$i])));
        }
    }

    return join('', $str);
}

/**
 * 我再送你一个,把下面作为php的一个函数,调用它就可以.编码为UTF-8
 * php js_unescape correspond to js escape.
 *
 * @param $str
 *
 * @return string
 */
function jsUnescape($str)
{
    $ret = '';
    $len = mb_strlen($str);

    for ($i = 0; $i < $len; ++$i) {
        if ('%' == $str[$i] && 'u' == $str[$i + 1]) {
            $val = hexdec(mb_substr($str, $i + 2, 4));
            if ($val < 0x7f) {
                $ret .= chr($val);
            } elseif ($val < 0x800) {
                $ret .= chr(0xc0 | ($val >> 6)) . chr(0x80 | ($val & 0x3f));
            } else {
                $ret .= chr(0xe0 | ($val >> 12)) . chr(0x80 | (($val >> 6) & 0x3f)) . chr(0x80 | ($val & 0x3f));
            }
            $i += 5;
        } elseif ('%' == $str[$i]) {
            $ret .= urldecode(mb_substr($str, $i, 3));
            $i += 2;
        } else {
            $ret .= $str[$i];
        }
    }

    return $ret;
}
