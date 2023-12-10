<?php 

declare(strict_types=1);

namespace app\database\repositories;

use app\database\entities\PasswordRecoveryEntity;
use core\database\Model;

class PasswordRecoveryRepository extends Model {
    
    protected string $repositoryClassName = PasswordRecoveryEntity::class;
}
?>