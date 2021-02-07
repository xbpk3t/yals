<?php

namespace Modules\Common\Utils\Filter;

interface Filter
{
    public function getBadWords($content, $matchType = 1, $count = 0);

    public function isLegal($content);
}
