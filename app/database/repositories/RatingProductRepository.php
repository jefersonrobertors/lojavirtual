<?php 

declare(strict_types=1);

namespace app\database\repositories;

use app\database\entities\RatingProductEntity;

use core\database\Model;

class RatingProductRepository extends Model {

    /** @var string $repositoryClassName*/
    protected string $repositoryClassName = RatingProductEntity::class;
}
?>