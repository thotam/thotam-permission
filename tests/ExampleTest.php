<?php

namespace Thotam\ThotamPermission\Tests;

use Orchestra\Testbench\TestCase;
use Thotam\ThotamPermission\ThotamPermissionServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ThotamPermissionServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
