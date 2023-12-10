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
#[Table(name: 'password_tokens')]
class PasswordRecoveryEntity {

    #[Id]
    #[Column(name: 'id', type: Types::INTEGER)]
    #[GeneratedValue()]
    private int $id;

    #[Column(name: 'email', type: Types::STRING)]
    private string $email;

    #[Column(name: 'token', type: Types::STRING)]
    private string $token;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private \DateTime $created_at;

    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function setEmail(string $email) : void {
        $this->email = $email;
    }

    public function getToken() : string {
        return $this->token;
    }

    public function setToken(string $token) : void {
        $this->token = $token;
    }

    public function getCreatedAt() : \DateTime {
        return $this->created_at;
    }

    public function setCreatedAt($datetime) : void {
        $this->created_at = $datetime;
    }
}
?>