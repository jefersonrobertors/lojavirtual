<?php

declare(strict_types=1);

namespace app\helpers;

use app\interfaces\ProductInterface;

class Product implements ProductInterface {

    private int $id;
    private string $name;
    private string $description;
    private string $price;
    private int $quantity = 1;
    private $image;

    public function getId() : int {
        return $this->id;
    }

    public function setId($id) : void {
        $this->id = $id;
    }

    public function getQuantity() : int {
        return $this->quantity;
    }

    public function setQuantity($quantity) : void {
        $this->quantity = $quantity;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName($name) : void {
        $this->name = $name;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription($description) : void {
        $this->description = $description;
    }

    public function getPrice() : string {
        return $this->price;
    }

    public function setPrice($price) : void {
        $this->price = $price;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) : void {
        $this->image = $image;
    }
}
?>