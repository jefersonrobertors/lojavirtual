<?php

declare(strict_types=1);

namespace app\helpers;

final class Cart {

    public function add(Product $item) : void {
        $items = $this->getItems();
        
        if(isset($items[$item->getid()])) {
            $product = $items[$item->getId()];
            $item->setQuantity($product->getQuantity() + $item->getQuantity());
            unset($items[$item->getId()]);
        }
        $items[$item->getId()] = $item;

        session()->cart = $items;
    }

    public function remove(Product $item): void {
        $items = $this->getItems();

        if(isset($items[$item->getId()])) {
            unset($items[$item->getId()]);
        }
        session()->cart = $items;
    }

    public function reduce(int $id) : bool {
        $items = $this->getItems();

        if(!isset($items[$id])) {
            return false;
        }
        $item = $items[$id];

        if($item->getQuantity() > 1) {
            $item->setQuantity($item->getQuantity() - 1);
        }else{
            $this->remove($item);
        }
        session()->cart = $items;
        return true;
    }

    public function getItems() : array {
        $session = session();
        $items = isset($session->cart) ? $session->cart : [];
        return $items;
    }
}
?>