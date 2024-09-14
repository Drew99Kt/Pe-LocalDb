<?php
namespace LocalDb;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase {
    private static ?LocalDb $cache = null;

    public function onEnable(): void {
        // Optionally initialize here if needed
        $this->getLogger()->info("CachePlugin enabled!");
    }

    public static function getCache() {
        if (self::$cache === null) {
            self::$cache = new LocalDb(); // Lazy initialization
        }
        return self::$cache;
    }
}