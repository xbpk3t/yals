<?php

namespace Modules\Common\Utils\SensitiveWord;

interface Filter
{
    public function getBadWords(string $content, int $matchType = 1, int $count = 0);

    public function isLegal(string $content);
}
