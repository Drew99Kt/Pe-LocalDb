<?php
namespace LocalDb;

use pocketmine\utils\Config;

class LocalDb implements LocalDbInterface {
    private Config $cache;

    public function __construct() {
        $this->cache = new Config("plugin_data/LocalDb/cache.yml", Config::YAML);
    }

    public function set(string $key, $value): void {
        $this->cache->set($key, ['value' => $value]);
        $this->cache->save();
    }
    public function setByPlayerId(string $playerId, string $key, $value): void {
        $this->validatePlayerId($playerId);
        $data = $this->cache->get($playerId, []);
        $keys = explode('.', $key);
        $temp = &$data;
        foreach ($keys as $k) {
            if (!isset($temp[$k])) {
                $temp[$k] = [];
            }
            $temp = &$temp[$k];
        }
        $temp = $value;
        $this->cache->set($playerId, $data);
        $this->cache->save();
    }
    public function getByPlayerId(string $playerId, string $key) {
        $this->validatePlayerId($playerId);
        $data = $this->cache->get($playerId, []);
        $keys = explode('.', $key);
        foreach ($keys as $k) {
            if (!isset($data[$k])) {
                return null;
            }
            $data = $data[$k];
        }
        return $data;
    }
    public function deleteByPlayerId(string $playerId, string $key): void {
        $this->validatePlayerId($playerId);
        $data = $this->cache->get($playerId, []);
        $keys = explode('.', $key);
        $temp = &$data;
        foreach ($keys as $k) {
            if (!isset($temp[$k])) {
                return;
            }
            $temp = &$temp[$k];
        }
        unset($temp);
        $this->cache->set($playerId, $data);
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
    private function validatePlayerId(string $playerId){

        $v =  preg_match('/[a-f0-9]{8}-[a-f0-9]{4}-[1-5][a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}/', $playerId) === 1;
        if(!$v){
            throw new \InvalidArgumentException("Invalid player id");
        }
    }
}
