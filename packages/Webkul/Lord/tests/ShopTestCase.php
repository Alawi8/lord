<?php

namespace Webkul\Lord\Tests;

use Tests\TestCase;
use Webkul\Core\Tests\Concerns\CoreAssertions;
use Webkul\Lord\Tests\Concerns\LordTestBench;

class LordTestCase extends TestCase
{
    use CoreAssertions, LordTestBench;
}
