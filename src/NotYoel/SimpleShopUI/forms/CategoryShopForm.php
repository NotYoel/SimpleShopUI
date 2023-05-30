<?php

namespace NotYoel\SimpleShopUI\forms;

use pocketmine\player\Player;
use dktapps\pmforms\MenuForm;
use NotYoel\SimpleShopUI\Loader;
use NotYoel\SimpleShopUI\shop\ShopCategory;
use dktapps\pmforms\MenuOption;
use NotYoel\SimpleShopUI\shop\ShopItem;

class CategoryShopForm{

    public function __construct(private Player $player, private ShopCategory $shopCategory){  
        $player->sendForm($this->getForm());      
    }

    public function getForm(){
        $content = $this->shopCategory->getItems();

        $options = array_map(function(ShopItem $shopItem) : MenuOption{
            return new MenuOption("§r" . $shopItem->getItem()->getName() . "\n§r§8Price: $" . number_format($shopItem->getPrice()));
        }, $content);



        $form = new MenuForm("ShopUI", "Pick an item.", $options, function(Player $submitter, int $selected) use($content) : void{
            $shopItem = $content[$selected];

            new BuyItemForm($submitter, $shopItem);
        });

        return $form;
    }
}