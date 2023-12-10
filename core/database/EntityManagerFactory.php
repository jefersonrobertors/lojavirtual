<?php

declare(strict_types=1);

namespace core\database;

use core\helpers\Server;

use Doctrine\DBAL\DriverManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;

final class EntityManagerFactory {

    public static function getEntityManager() : EntityManagerInterface {
        $options = [
            'dbname' => env('DB_DATABASE'),
            'user' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'port' => env('DB_PORT'),
            'host' => env('DB_HOST'),
            'driver' => env('DB_DRIVER'),
        ];
        $rootDir = Server::create()->getPathApplication() . DIRECTORY_SEPARATOR;
        return new EntityManager(DriverManager::getConnection($options), ORMSetup::createAttributeMetadataConfiguration([$rootDir], true));
    }
}
?>