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
use LocalDb\LocalDbInterface;


class YourPlugin extends PluginBase {

    public LocalDbInterface $localDb;

    public function onEnable(): void {
    	//define $localDb
        $this->localDb = LocalDb::getCache();

        //example: getting name of this plugin
        $this->pluginName = $this->getName();
        //setting a key in localDb with the plugin name
		$this->localDb->set( $this->pluginName, "example_key");
		//get the value
		$value =  $this->localDb->get( $this->pluginName);
		//print the value
        $this->getLogger()->info("Cached value: " . $value);

        // Delete a localDb entry
        $this->localDb->delete($pluginName);

        // Clear all localDb entries
       	$this->localDb->clear();
    }
}

        // Clear all localDb entries
        $localDb->clear();
    }
}
