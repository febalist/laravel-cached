<?php

namespace Tests;

use Febalist\Laravel\Cached\Cached;
use Illuminate\Support\Facades\Cache;
use Orchestra\Testbench\TestCase;
use RuntimeException;

class CachedTest extends TestCase
{
    public function test_unavailable_methods()
    {
        $cached = new Cached('foo');

        $this->expectException(RuntimeException::class);
        $cached->clear();
    }

    public function test_common()
    {
        $cached = new Cached('foo');

        $this->assertNull($cached->get());
        $this->assertEquals('bar', $cached->get('bar'));

        $cached->put('baz');
        $this->assertEquals('baz', Cache::get('foo'));
        $this->assertEquals('baz', $cached->get());

        $cached->delete();
        $this->assertFalse($cached->has());
    }

    public function test_default()
    {
        $cached = new Cached('foo', 'bar');

        $this->assertEquals('bar', $cached->get());
        $this->assertEquals('baz', $cached->get('baz'));

        $cached->put('baz');

        $this->assertNotEquals('bar', $cached);
    }

    public function test_driver()
    {
        $file = new Cached('foo', null, 'file');
        $array = new Cached('foo', null, 'array');

        $file->put('bar');
        $array->put('baz');

        $this->assertEquals('bar', $file->get());
        $this->assertEquals('baz', $array->get());
    }

    public function test_helper()
    {
        $cached = cached('foo', 'bar');

        $this->assertInstanceOf(Cached::class, $cached);
        $this->assertEquals('foo', $cached->key);
        $this->assertEquals('bar', $cached->default);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
        Cache::store('file')->flush();
        Cache::store('array')->flush();
    }
}
