<?php
namespace LocalDb;

interface LocalDbInterface {
    public function set(string $key, $value): void;
    public function setByPlayerId(string $playerId,string $key, $value): void;
    public function getByPlayerId(string $playerId,string $key);
    public function deleteByPlayerId(string $playerId,string $key): void;
    public function get(string $key);
    public function delete(string $key): void;
    public function clear(): void;
}
