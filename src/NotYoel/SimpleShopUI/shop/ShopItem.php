<?php

namespace NotYoel\SimpleShopUI\shop;

use pocketmine\item\Item;

class ShopItem{

    public function __construct(private int $price, private Item $item){}

    public function getPrice() : int{
        return $this->price;
    }

    public function getItem() : Item{
        return clone $this->item;
    }
}