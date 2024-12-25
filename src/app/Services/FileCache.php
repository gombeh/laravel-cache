<?php

namespace App\Services;

use Carbon\Carbon;
use Closure;

class FileCache extends BaseCache
{
    public array $data = [];
    public string $path;

    public function __construct()
    {
        $this->path = config('custom-cache.stores.file.path') . '/cache.txt';
        $this->syncData();
    }

    public function get(string $key, mixed $value, ?int $ttl = null): mixed
    {
        if (key_exists($key, $this->data)) {
            $data = $this->data[$key];
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
        $this->data[$key] = $this->prepareDataForSet($value, $ttl);

        file_put_contents($this->path, serialize($this->data));

        return $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function forget($key): bool
    {
        $flag = false;

        if($this->data[$key] ?? false) {
            $flag = true;
            unset($this->data[$key]);
            file_put_contents($this->path, serialize($this->data));
        }

        return $flag;
    }

    /**
     * @return void
     */
    private function syncData(): void
    {
        if (file_exists($this->path)) {
            $rawData = file_get_contents($this->path);
            $data = unserialize($rawData);
            $this->data = $data === false ? [] : $data;
        } else {
            file_put_contents($this->path, $this->data);
        }
    }
}
