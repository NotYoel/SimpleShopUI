<?php

namespace NotYoel\SimpleShopUI\shop;

use NotYoel\SimpleShopUI\Loader;
use pocketmine\item\StringToItemParser;
use pocketmine\permission\Permission;
use pocketmine\utils\TextFormat as TF;
use pocketmine\permission\PermissionManager;

class ShopManager{

    /** @var ShopCategory[] $categories */
    private array $categories = [];

    public function __construct(){
        $cfg = Loader::getInstance()->getConfig();

        foreach($cfg->get("shop") as $category_name => $category_data){
            $items = [];

            foreach($category_data["items"] as $item_identifier => $item_data){
                $items[] = $this->configToShopItem($item_identifier, $item_data);
            }

            $this->categories[strtolower($category_name)] = new ShopCategory($category_name, $items);
        }
    }

    public function configToShopItem(string $item_identifier, array $item_data) : ?ShopItem{
        $item = StringToItemParser::getInstance()->parse($item_identifier);

        if($item == null) return null;

        $item->setCustomName(TF::RESET . $item_data["item_name"]);
        $item->setLore(array_map(fn(string $line) => TF::RESET . $line, $item_data["item_lore"]));

        $shopItem = new ShopItem($item_data["price"], $item);

        return $shopItem;
    }

    public function getShopCategory(string $category) : ?ShopCategory{
        return $this->categories[strtolower($category)] ?? null;
    }
    
    public function getShopCategories() : array{
        return $this->categories;
    }
}