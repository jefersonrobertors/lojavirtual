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
#[Table(name: 'rating')]
class RatingProductEntity {

    #[Id]
    #[Column(name: 'id', type: Types::INTEGER)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: 'product_id', type: Types::INTEGER)]
    private int $product_id;

    #[Column(name: 'customer_id', type: Types::INTEGER)]
    private int $customer_id;

    #[Column(name: 'rating', type: Types::INTEGER)]
    private int $rating;

    #[Column(name: 'comment', type: Types::STRING)]
    private string $comment;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private \DateTime $created_at;

    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function getProductId() : int {
        return $this->product_id;
    }

    public function setProductId(int $id) : void {
        $this->product_id = $id;
    }

    public function getCustomerId() : int {
        return $this->customer_id;
    }

    public function setCustomerId(int $id) : void {
        $this->customer_id = $id;
    }

    public function getRating() : int {
        return $this->rating;
    }

    public function setRating(int $rating) : void {
        $this->rating = $rating;
    }

    public function getComment() : string {
        return $this->comment;
    }

    public function setComment(string $comment) : void {
        $this->comment = $comment;
    }

    public function getCreatedAt() : \DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $datetime) : void {
        $this->created_at = $datetime;
    }
}
?>