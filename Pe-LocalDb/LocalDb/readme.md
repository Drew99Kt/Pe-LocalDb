# CachePlugin

CachePlugin is a caching system for PocketMine-MP that provides caching services to all plugins. This plugin allows other plugins to store, retrieve, and manage cached data efficiently.

## Features

- Set, get, and delete cache entries
- Clear all cache entries
- Organized cache entries by plugin name or player id

## Installation
1. Place the `LocalDb` file in the `plugins` directory of your PocketMine-MP server.
2. Start or restart your server.

## Usage

### Accessing the Cache

To use the caching system in your plugin, you need to access the cache provided by CachePlugin. Here is an example of how to do this:

```php
use LocalDb\Main as LocalDb;

class YourPlugin extends PluginBase {
    public function onEnable(): void {
        $localDb = LocalDb::getCache();
        $pluginName = $this->getName();

        // Set a localDb entry
        $localDb->set($pluginName, "example_key", "example_value");

        // Get a localDb entry
        $value = $localDb->get($pluginName, "example_key");
        $this->getLogger()->info("Cached value: " . $value);

        // Delete a localDb entry
        $localDb->delete($pluginName, "example_key");

        // Clear all localDb entries
        $localDb->clear();
    }
}
