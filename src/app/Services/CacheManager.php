<?php

namespace App\Services;

class CacheManager
{
    /**
     * @param $driver
     * @return BaseCache
     */
    public function driver($driver = null): BaseCache
    {
        return $this->resolve($driver);
    }

    /**
     * @param $driver
     * @return BaseCache
     */
    public function resolve($driver = null): BaseCache
    {
        $driver = $driver ?? config('custom-cache.default', $driver);

        $driverClass = match ($driver) {
            "file" => FileCache::class,
            "redis" => RedisCache::class,
            "database" => DatabaseCache::class,
        };

        return new $driverClass();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->resolve()->{$name}(...$arguments);
    }
}
