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

namespace CoolStuff\Suppliers\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use CoolStuff\Suppliers\Domain\Repository\Repository;

/**
 * Class AbstractDoctrineRepository.
 *
 * @package CoolStuff\Partners\Persistence\Doctrine\Repository
 */
abstract class AbstractDoctrineRepository implements Repository
{
    protected EntityManagerInterface $entityManager;

    protected string $entityClass;

    public function __construct(EntityManagerInterface $em)
    {
        if (empty($this->entityClass)) {
            throw new \RuntimeException(get_class($this).'::$entityClass is not defined');
        }

        $this->entityManager = $em;
    }

    public function getAll()
    {
        return $this->entityManager->getRepository($this->entityClass)
            ->findAll();
    }

    public function getBy($conditions = [], $order = [], $limit = null, $offset = null)
    {
        $repository = $this->entityManager->getRepository($this->entityClass);

        return $repository->findBy($conditions, $order, $limit, $offset);
    }

    /**
     * @param $entity
     * @return $this
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);

        return $this;
    }

    /**
     * @return $this
     */
    public function begin()
    {
        $this->entityManager->beginTransaction();

        return $this;
    }

    /**
     * @return $this
     */
    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();

        return $this;
    }
}
