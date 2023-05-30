<?php

namespace NotYoel\SimpleShopUI\commands;

use NotYoel\SimpleShopUI\forms\MainShopForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class ShopCommand extends Command{

    public function __construct(){
        parent::__construct("shop", "Opens the ShopUI", "/shop");
        $this->setPermission("shop.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
        new MainShopForm($sender);
    }
}