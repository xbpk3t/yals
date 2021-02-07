<?php

namespace Modules\Common\Tests\Feature;

use Illuminate\Support\Facades\Log;
use Modules\Common\Utils\Filter\FilterProcessChain;
use Modules\Common\Utils\Filter\SensitiveFilter;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use FilterProcessChain;


    public function testFilter()
    {
        $contents = '微信';

        $chain = $this->addChain(new SensitiveFilter());
        self::assertTrue($chain->isLegal($contents));
    }
}
