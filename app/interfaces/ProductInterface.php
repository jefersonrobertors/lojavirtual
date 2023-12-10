<?php

namespace app\interfaces;

interface ProductInterface {
 
    public function getId() : int;
    public function getName() : string;
    public function getPrice() : string;
    public function getDescription() : string;
    public function getImage();

    public function setId($id) : void;
    public function setName($name) : void;
    public function setPrice($price) : void;
    public function setDescription($description) : void;
    public function setImage($image) : void;
}
?>