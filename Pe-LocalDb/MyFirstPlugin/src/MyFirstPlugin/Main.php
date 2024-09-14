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
        $this->localDb = LocalDb::getCache();
        $this->pluginName = $this->getName();
        $this->localDb->set( $this->pluginName, "example_key", "example_value");
        $value =  $this->localDb->get( $this->pluginName, "example_key");
        $this->getLogger()->info("Cached value: " . $value);
        $this->getLogger()->info(TextFormat::GREEN . "MyFirstPlugin has been enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable(): void {
        $this->getLogger()->info(TextFormat::RED . "MyFirstPlugin has been disabled!");
    }
    public function onBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();
        //$player->sendMessage($event);
      
        $this->localDb->set( "{$event->getPlayer()->getUniqueId()}-lastBlockBroke",  $event->getBlock()->getName());
        
        $blockBreakCount =  $this->localDb->get("{$event->getPlayer()->getUniqueId()}-brokeCount-{$event->getBlock()->getName()}");
        if($blockBreakCount === null) {
            $blockBreakCount = 1;
        }
        $this->localDb->set( "{$event->getPlayer()->getUniqueId()}-brokeCount-{$event->getBlock()->getName()}",  $blockBreakCount+1);
        $value =  $this->localDb->get( "{$event->getPlayer()->getUniqueId()}-lastBlockBroke");
        
        $player->sendMessage(TextFormat::YELLOW . "The last block you broke was { $value}, you have broken { $blockBreakCount} of them");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
       

        $money = EconomyAPI::getInstance()->myMoney($sender->getName());
       
  
        if ($command->getName() === "restartplugin") {
            $sender->sendMessage("Hello " . $money . "!");
            return true;
        }
        
        if($command->getName() === "hello") {
            
            return true;
        }
        return false;
    }
}