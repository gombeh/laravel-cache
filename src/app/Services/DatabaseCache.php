<?php

namespace App\Services;


use App\Models\Cache as CacheModel;
use Closure;

class DatabaseCache extends BaseCache
{
    public function get(string $key, mixed $value, ?int $ttl = null): mixed
    {
        $data = CacheModel::where('key', $key)
            ->first();

        if ($data) {
            if ($data->expire_at && now()->gte($data->expire_at)) {
                return $value !== null ? $this->set($key, $value, $ttl) : null;
            }
            return $data->value;
        }

        return $value !== null ? $this->set($key, $value, $ttl) : null;
    }

    public function set(string $key, mixed $value, ?int $ttl = null): mixed
    {
        $value = $value instanceof Closure ? $value() : $value;

        CacheModel::updateOrCreate(['key' => $key],  [
            'value' => $value,
            'expire_at' => $ttl ? now()->addSeconds($ttl) : null,
        ]);

        return $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function forget($key): bool
    {
        return CacheModel::where('key', $key)->delete();
    }
}
