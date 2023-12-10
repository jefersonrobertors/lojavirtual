<?php 

declare(strict_types=1);

namespace app\database\repositories;

use app\database\entities\ProductEntity;

use core\database\Model;

class ProductRepository extends Model {

    /** @var string $repositoryClassName*/
    protected string $repositoryClassName = ProductEntity::class;
}
?>