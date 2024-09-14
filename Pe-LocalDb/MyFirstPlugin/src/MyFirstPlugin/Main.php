<?php

namespace MyFirstPlugin;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use onebone\economyapi\EconomyAPI;
use LocalDb\Main as LocalDb; // Add this line to import CachePlugin
use LocalDb\LocalDbInterface;
use pocketmine\event\block\BlockBreakEvent;

class Main extends PluginBase implements Listener {

    public LocalDbInterface $localDb;
    private string $pluginName = "";

    
    public function onEnable(): void {
        //set the cache in the current plugin
        $this->localDb = LocalDb::getCache();
        //if you wanted you could set keys with the plugin name
        $this->pluginName = $this->getName();
        //setting a key specific to the plugin
        $this->localDb->set( $this->pluginName, "example_key", "example_value");
        //getting the plugin key
        $value =  $this->localDb->get( $this->pluginName, "example_key");
        //printing in the console
        $this->getLogger()->info("Cached value: " . $value);
        $this->getLogger()->info(TextFormat::GREEN . "MyFirstPlugin has been enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable(): void {
        $this->getLogger()->info(TextFormat::RED . "MyFirstPlugin has been disabled!");
    }
    public function onBreak(BlockBreakEvent $event): void {
        //get the player fromd the block break event
        $player = $event->getPlayer();
        //$player->sendMessage($event);

        //setting the last block broke by the player
        $this->localDb->set( "{$event->getPlayer()->getUniqueId()}-lastBlockBroke",  $event->getBlock()->getName());
        //get the count of blocks of this type the player has broken
        $blockBreakCount =  $this->localDb->get("{$event->getPlayer()->getUniqueId()}-brokeCount-{$event->getBlock()->getName()}");
        //if this is the first time the player has broken this block then we need to set it to one
        if($blockBreakCount === null) {
            $blockBreakCount = 1;
        }
        //setting the block broke counter in for this player
        $this->localDb->set( "{$event->getPlayer()->getUniqueId()}-brokeCount-{$event->getBlock()->getName()}",  $blockBreakCount+1);
        //get the value of for last broken block
        $value =  $this->localDb->get( "{$event->getPlayer()->getUniqueId()}-lastBlockBroke");
        //send a message to the player letting them know what block they broke and the number of blocks of that type they have broken.
        $player->sendMessage(TextFormat::YELLOW . "The last block you broke was { $value}, you have broken { $blockBreakCount} of them");
    }

}
