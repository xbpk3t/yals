<?php

namespace Modules\Common\Utils\SensitiveWord;

trait FilterProcessChain
{
    public function addChain(Filter $filter)
    {
        return $filter;
    }

//    public function getBadWords(Filter $filter, string $msg)
//    {
//        return $filter->getBadWords($msg);
//    }
//
//    public function isLegal(Filter $filter, string $msg)
//    {
//        return $filter->isLegal($msg);
//    }
}
