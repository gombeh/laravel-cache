<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

/**
 * @method static BaseCache driver(string $key)
 * @method static mixed get(string $key, mixed $value, ?int $ttl = null)
 * @method static mixed set(string $key, mixed $value, ?int $ttl = null)
 * @method static bool forget(string $key)
 */
class Cache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'custom-cache';
    }
}
