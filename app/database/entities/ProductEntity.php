<?php

declare(strict_types=1);

namespace app\database\entities;

use Doctrine\DBAL\Types\Types;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'products')]
class ProductEntity {

    #[Id]
    #[Column(name: 'id', type: Types::INTEGER)]
    #[GeneratedValue]
    private int $id;

    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }
}
?>