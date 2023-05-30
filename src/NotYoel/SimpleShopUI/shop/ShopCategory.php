<?php

namespace NotYoel\SimpleShopUI\shop;

class ShopCategory{

    public function __construct(private string $category_name, private array $items){}


    public function getCategoryName() : string{
        return $this->category_name;
    }

    /**
     * @return ShopItem[]
     */
    public function getItems() : array{
        return $this->items;
    }
}