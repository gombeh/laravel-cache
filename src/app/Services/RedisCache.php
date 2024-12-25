<?php

namespace App\Services;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Redis;

class RedisCache extends BaseCache
{
    public function get(string $key, mixed $value, ?int $ttl = null): mixed
    {
        $data = unserialize(Redis::get($key));
        if ($data) {
            if ($data['expire_at'] && now()->gte(Carbon::createFromTimestamp($data['expire_at']))) {
                return $value !== null ? $this->set($key, $value, $ttl) : null;
            }
            return $data['data'];
        }
        return $value !== null ? $this->set($key, $value, $ttl) : null;

    }

    public function set(string $key, mixed $value, ?int $ttl = null): mixed
    {
        $value = $value instanceof Closure ? $value() : $value;
        $data =  $this->prepareDataForSet($value, $ttl);

        Redis::set($key, serialize($data));

        return $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function forget($key): bool
    {
        return Redis::del($key);
    }
}
