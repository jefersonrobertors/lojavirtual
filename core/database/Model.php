<?php

declare(strict_types=1);

namespace core\database;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class Model {

    /** @var string $repositoryClassName */
    protected string $repositoryClassName;

    /** @var Connection $connection */
    protected readonly Connection $connection;

    /** @var EntityManagerInterface $manager */
    protected readonly EntityManagerInterface $manager;

    /** @var EntityRepository $repository */
    protected readonly EntityRepository $repository; 

    protected $entity;

    public function __construct() {
        $this->manager = EntityManagerFactory::getEntityManager();
        $this->entity = new $this->repositoryClassName;
        $this->repository = $this->manager->getRepository($this->repositoryClassName);
        $this->connection = $this->manager->getConnection();
    }

    public static function create() : static {
        return new static;
    }

    public function fetchById(int $id) : ?object {
        return $this->repository->find($id);
    }

    public function fetchByField(string $field, mixed $value) : ?object {
        return $this->repository->findOneBy([$field => $value]);
    }

    public function fetchByFields(array $options) : ?object {
        return $this->repository->findOneBy($options);
    }

    public function fetchAll() : array {
        return $this->repository->findAll();
    }

    public function update(int $id, string $field, mixed $value) : bool {
        $entity = $this->repository->find($id);

        if(!isset($entity->$field)) {
            return false;
        }
        $entity->$field = $value;
        
        $this->manager->persist($entity);
        $this->manager->flush();
        return true;
    }

    public function parseMethod(string $key, string $method = 'set') : string {
        if(str_contains($key, '_')) {
            foreach(explode('_', $key) as $info) {
                $method .= strtoupper(substr($info, 0, 1)) . strtolower(substr($info, 1));
            }
        }else{
            $method .= strtoupper(substr($key, 0, 1)) . strtolower(substr($key, 1));
        }
        return $method;
    }

    public function insert(array $data) : void {
        foreach($data as $key => $value) {
            if(!property_exists($this->entity, $key)) {
                continue;
            }
            $method = $this->parseMethod($key, 'set');

            if(!method_exists($this->entity, $method)) {
                continue;
            }
            $this->entity->$method($value);
        }
        $this->manager->persist($this->entity);
        $this->manager->flush();
    }
}
?>