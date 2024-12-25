<?php

namespace App\Services;

abstract class BaseCache
{
    public abstract function get(string $key, mixed $value, ?int $ttl): mixed;

    public abstract function set(string $key, mixed $value, ?int $ttl): mixed;

    public abstract function forget(string $key): bool;

    public function prepareDataForSet(mixed $value, ?int $ttl = null, string $key = 'data'): mixed
    {
        return [
            $key => $value,
            'expire_at' => $ttl ? now()->addSeconds($ttl)->timestamp : null,
        ];
    }
}
