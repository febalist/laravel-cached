<?php

namespace Febalist\Laravel\Cached;

use Cache;
use Closure;

class Cached
{
    public $key;
    public $default;
    public $driver;

    public function __construct($key, $default = null)
    {
        $this->key = $key;
        $this->default = $default;
    }

    /**
     * Fetches a value from the cache.
     *
     * @param mixed $default Default value to return if the key does not exist.
     *
     * @return mixed The value of the item from the cache, or $default in case of cache miss.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public function get($default = null)
    {
        return $this->cache()->get($this->key, func_num_args() ? $default : $this->default);
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * NOTE: It is recommended that has() is only to be used for cache warming type purposes
     * and not to be used within your live applications operations for get/set, as this method
     * is subject to a race condition where your has() will return true and immediately after,
     * another script can remove it making the state of your app out of date.
     *
     * @return bool
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public function has()
    {
        return $this->cache()->has($this->key);
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param mixed $default
     * @return mixed
     */
    public function pull($default = null)
    {
        return $this->cache()->pull($this->key, func_num_args() ? $default : $this->default);
    }

    /**
     * Store an item in the cache.
     *
     * @param mixed                                     $value
     * @param \DateTimeInterface|\DateInterval|int|null $ttl
     * @return bool
     */
    public function put($value, $ttl = null)
    {
        return $this->cache()->put($this->key, $value, $ttl);
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param string                                    $key
     * @param mixed                                     $value
     * @param \DateTimeInterface|\DateInterval|int|null $ttl
     * @return bool
     */
    public function add($value, $ttl = null)
    {
        return $this->cache()->add($this->key, $value, $ttl);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param mixed $value
     * @return int|bool
     */
    public function increment($value = 1)
    {
        return $this->cache()->increment($this->key, $value);
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param mixed $value
     * @return int|bool
     */
    public function decrement($value = 1)
    {
        return $this->cache()->decrement($this->key, $value);
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param mixed $value
     * @return bool
     */
    public function forever($value)
    {
        return $this->cache()->forever($this->key, $value);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param \DateTimeInterface|\DateInterval|int|null $ttl
     * @param \Closure                                  $callback
     * @return mixed
     */
    public function remember($ttl, Closure $callback)
    {
        return $this->cache()->remember($this->key, $ttl, $callback);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param \Closure $callback
     * @return mixed
     */
    public function sear(Closure $callback)
    {
        return $this->cache()->remember($this->key, $callback);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param \Closure $callback
     * @return mixed
     */
    public function rememberForever(Closure $callback)
    {
        return $this->cache()->rememberForever($this->key, $callback);
    }

    /**
     * Remove an item from the cache.
     *
     * @return bool
     */
    public function forget($key)
    {
        return $this->cache()->forget($this->key);
    }

    /** @return \Illuminate\Cache\Repository */
    protected function cache()
    {
        return Cache::driver($this->driver);
    }
}
