<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithFaker;
use AvtoDev\DevTools\Tests\PHPUnit\AbstractLaravelTestCase;

abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    use WithFaker;
}
