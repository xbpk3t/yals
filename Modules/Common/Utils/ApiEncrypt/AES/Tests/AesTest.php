<?php


namespace Modules\Common\Utils\ApiEncrypt\AES\Tests;


use Tests\TestCase;

class AesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        \Route::middleware([
            'aes.encrypt',
            'aes.decrypt'
        ])->get('/api/sign', function () {
            return response()->setContent(['username' => 'jf']);
        });
    }

    public function testDecrypt()
    {
        $cipher = 'eyJpdiI6IksvOUtpVEtyMUw0MkhRQkUzYU1rbnc9PSIsInZhbHVlIjoiQWluMDI5YTN6Z2FKTmNOZEdyZUJJVmlUQ0FMSHorRVl0bzZzSmhIQXFlR2x0YWFPMXBWd1lYek9UZDJROWl1OU50SmNuL2k0QzZ3MkVLRVpFTW1RWnc9PSIsIm1hYyI6ImE1OTc5NWMxNGZiMTk1M2M1MDY4M2EwNzlkYWNkYTU2NDQ1ZDdmYzAzM2QzMzEwN2RmNTUyMDcxYWMyZDBlZjUifQ==';


    }
}
