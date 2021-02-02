<?php

if (!function_exists('getUserConstellation')) {
    /**
     * 获取用户的星座.
     *
     * @param string $birthday
     *
     * @return string
     */
    function getUserConstellation(string $birthday): string
    {
        $birthdayInfo = parseBirthday($birthday);
        $month = $birthdayInfo['month'];
        $day = $birthdayInfo['day'];

        $constellations = '魔羯水瓶双鱼白羊金牛双子巨蟹狮子处女天秤天蝎射手魔羯';
        $arr = [20, 19, 21, 21, 21, 22, 23, 23, 23, 23, 22, 22];

        return mb_substr(
            $constellations,
            $month * 2 - ($day < $arr[$month - 1] ? 2 : 0),
            2,
            'UTF-8'
        );
    }
}


if (!function_exists('parseBirthday')) {
    function parseBirthday(string $birthday)
    {
        preg_match('/(.{4})(.{2})(.{2})/', $birthday, $matches);

        return ['year' => $matches[1], 'month' => $matches[2], 'day' => $matches[3]];
    }
}

