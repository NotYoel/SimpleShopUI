<?php

namespace NotYoel\SimpleShopUI\forms;

use pocketmine\player\Player;
use dktapps\pmforms\MenuForm;
use NotYoel\SimpleShopUI\Loader;
use NotYoel\SimpleShopUI\shop\ShopCategory;
use dktapps\pmforms\MenuOption;

class MainShopForm{

    public function __construct(private Player $player){  
        $player->sendForm($this->getForm());      
    }

    public function getForm(){
        $content = array_values(Loader::getInstance()->getShopManager()->getShopCategories());

        $options = array_map(function(ShopCategory $shopCategory) : MenuOption{
            return new MenuOption($shopCategory->getCategoryName());
        }, $content);

        $form = new MenuForm("ShopUI", "Select a category.", $options, function(Player $submitter, int $selected) use($content) : void{
            new CategoryShopForm($submitter, $content[$selected]);
        });

        return $form;
    }
}