<?php
namespace LocalDb;

interface LocalDbInterface {
    public function set(string $key, $value): void;
    public function get(string $key);
    public function delete(string $key): void;
    public function clear(): void;
}