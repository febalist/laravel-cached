<?php

namespace Febalist\Laravel\Cached;

use Closure;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use ReflectionMethod;
use RuntimeException;

/**
 * @method bool has()
 * @method bool missing()
 * @method mixed get($default = null)
 * @method mixed pull($default = null)
 * @method bool put($value, $ttl = null)
 * @method bool set($value, $ttl = null)
 * @method bool add($value, $ttl = null)
 * @method int|bool increment($value = 1)
 * @method int|bool decrement($value = 1)
 * @method bool forever($value)
 * @method mixed remember($ttl, Closure $callback)
 * @method mixed sear(Closure $callback)
 * @method mixed rememberForever(Closure $callback)
 * @method bool forget()
 * @method bool delete()
 * @method bool offsetExists()
 * @method mixed offsetGet()
 * @method void offsetSet($value)
 * @method void offsetUnset()
 */
class Cached
{
    public $key;
    public $default;

    /** @var Repository */
    protected $cache;

    public function __construct($key, $default = null, $driver = null)
    {
        $this->key = $key;
        $this->default = $default;
        $this->cache = Cache::driver($driver);
    }

    public function __call($name, $arguments)
    {
        $method = new ReflectionMethod($this->cache, $name);
        $params = $method->getParameters();

        if (!$params || $params[0]->name !== 'key') {
            throw new RuntimeException("Method $name() unavailable");
        }

        array_unshift($arguments, $this->key);

        if (count($params) >= 2 && $params[1]->name === 'default' && !isset($arguments[1])) {
            $arguments[1] = $this->default;
        }

        return $this->cache->$name(...$arguments);
    }
}
