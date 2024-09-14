<?php
namespace LocalDb;

use pocketmine\utils\Config;

class LocalDb implements LocalDbInterface {
    private Config $cache;

    public function __construct() {
        $this->cache = new Config("cache.yml", Config::YAML);
    }

    public function set(string $key, $value): void {
        $this->cache->set($key, ['value' => $value]);
        $this->cache->save();
    }

    public function get(string $key) {
        $data = $this->cache->get($key);
        return $data['value'] ?? null;
    }

    public function delete(string $key): void {
        $this->cache->remove($key);
        $this->cache->save();
    }

    public function clear(): void {
        $this->cache->setAll([]);
        $this->cache->save();
    }
}