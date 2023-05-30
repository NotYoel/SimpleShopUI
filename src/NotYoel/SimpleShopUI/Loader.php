<?php

namespace NotYoel\SimpleShopUI;

use NotYoel\SimpleShopUI\commands\ShopCommand;
use NotYoel\SimpleShopUI\shop\ShopManager;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase{

    private static self $instance;
    private ShopManager $shopManager;

    protected function onEnable() : void{
        self::$instance = $this;

        $this->shopManager = new ShopManager();

        $this->getServer()->getCommandMap()->register("shop", new ShopCommand());

        $this->saveDefaultConfig();

        $this->getLogger()->info("SimpleShopUI has been enabled.");
    }

    public static function getInstance() : self{
        return self::$instance;
    }

    public function getShopManager() : ShopManager{
        return $this->shopManager;
    }
}