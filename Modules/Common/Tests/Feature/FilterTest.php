<?php

namespace Modules\Common\Tests\Feature;

use Tests\TestCase;
use Modules\Common\Utils\Filter\SensitiveFilter;
use Modules\Common\Utils\Filter\FilterProcessChain;

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
