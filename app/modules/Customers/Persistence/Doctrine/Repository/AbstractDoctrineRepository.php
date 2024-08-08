<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\Customers\Persistence\Doctrine\Repository;

use RuntimeException;
use Doctrine\ORM\EntityManagerInterface;
use CoolStuff\Customers\Domain\Repository\Repository;

/**
 * Class AbstractDoctrineRepository.
 *
 * @package CoolStuff\Customers\Persistence\Doctrine\Repository
 */
abstract class AbstractDoctrineRepository implements Repository
{
    protected EntityManagerInterface $entityManager;

    protected string $entityClass;

    /**
     * AbstractDoctrineRepository constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        if (empty($this->entityClass)) {
            throw new RuntimeException(get_class($this).'::$entityClass is not defined');
        }

        $this->entityManager = $em;
    }

    public function getAll(): mixed
    {
        return $this->entityManager->getRepository($this->entityClass)
            ->findAll();
    }

    /**
     * @param array $conditions
     * @param array $order
     * @param null $limit
     * @param null $offset
     * @return mixed
     */
    public function getBy($conditions = [], $order = [], $limit = null, $offset = null): mixed
    {
        $repository = $this->entityManager->getRepository($this->entityClass);

        return $repository->findBy($conditions, $order, $limit, $offset);
    }

    /**
     * @return $this
     */
    public function create($entity): Repository
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * @return $this
     */
    public function begin(): Repository
    {
        $this->entityManager->beginTransaction();

        return $this;
    }

    /**
     * @return $this
     */
    public function commit(): Repository
    {
        $this->entityManager->flush();
        $this->entityManager->commit();

        return $this;
    }
}
