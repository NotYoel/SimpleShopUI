<?php

namespace NotYoel\SimpleShopUI\forms;

use pocketmine\player\Player;
use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use NotYoel\SimpleShopUI\Loader;
use NotYoel\SimpleShopUI\shop\ShopCategory;
use dktapps\pmforms\element\Slider;
use NotYoel\SimpleShopUI\shop\ShopItem;
use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use cooldogedev\BedrockEconomy\libs\cooldogedev\libSQL\context\ClosureContext;

class BuyItemForm{

    public function __construct(private Player $player, private ShopItem $shopItem){  
        $player->sendForm($this->getForm());      
    }

    public function getForm(){
        $form = new CustomForm($this->shopItem->getItem()->getName(), [new Slider("Amount", "Amount", 1, 64)], function(Player $submitter, CustomFormResponse $customFormResponse) : void{
            $itemAmount = $customFormResponse->getFloat("Amount");
            $price = $itemAmount * $this->shopItem->getPrice();

            BedrockEconomyAPI::legacy()->subtractFromPlayerBalance(
                $submitter->getName(),
                $this->shopItem->getPrice(),
                ClosureContext::create(
                    function (bool $wasUpdated) use($submitter, $itemAmount, $price): void {
                        $itemName = $this->shopItem->getItem()->getName();

                        if($wasUpdated){
                            $submitter->sendMessage("§aSuccessfully purchased x{$itemAmount} {$itemName} §r§afor $" . number_format($price));
                            $submitter->getInventory()->addItem($this->shopItem->getItem()->setCount($itemAmount));
                        } else {
                            $submitter->sendMessage("§cYou don't have enough money to purchase x{$itemAmount} {$itemName}§r§c.");
                        }
                    },
                )
            );
        });

        return $form;
    }
}