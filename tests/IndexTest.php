<?php

namespace tests;

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    public function test1()
    {
        $this->assertSame('fooBar', 'fooBar');
    }

    public function test2()
    {
        $this->assertNotSame('fooBar', 'fooBar1');
    }
}
