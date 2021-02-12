<?php

namespace Modules\Common\Utils\SensitiveWord\Tests;

use Tests\TestCase;
use Modules\Common\Utils\SensitiveWord\SensitiveFilter;
use Modules\Common\Utils\SensitiveWord\FilterProcessChain;

/**
 * @coversNothing
 */
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
