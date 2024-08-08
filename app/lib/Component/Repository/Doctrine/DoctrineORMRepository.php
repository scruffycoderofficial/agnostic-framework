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

namespace CoolStuff\Component\Repository\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use CoolStuff\Component\Repository\Contract\ORMRepository;

/**
 * Class DoctrineORMRepository.
 *
 * @package CoolStuff\Component\Repository\Doctrine
 */
abstract class DoctrineORMRepository implements ORMRepository
{
    /**
     * This is Doctrine's Entity Manager. It's fine to expose it to the child class.
     */
    protected EntityManagerInterface $manager;

    /**
     * We don't want to expose the query builder to child classes.
     * This is so we are sure the original reference is not modified.
     *
     * We control the query builder state by providing clones with the `query`
     * method and by cloning it with the `filter` method.
     */
    private QueryBuilder $queryBuilder;

    /**
     * DoctrineORMRepository constructor.
     */
    public function __construct(EntityManagerInterface $manager, string $entityClass, string $alias)
    {
        $this->manager = $manager;
        $this->queryBuilder = $this->manager->createQueryBuilder()
            ->select($alias)
            ->from($entityClass, $alias);
    }

    public function getIterator(): \Iterator
    {
        yield from new Paginator($this->queryBuilder->getQuery());
    }

    public function slice(int $start, int $size = 20): ORMRepository
    {
        return $this->filter(static function (QueryBuilder $qb) use ($start, $size) {
            $qb->setFirstResult($start)->setMaxResults($size);
        });
    }

    public function count(): int
    {
        $paginator = new Paginator($this->queryBuilder->getQuery());

        return $paginator->count();
    }

    /**
     * Filters the repository using the query builder.
     *
     * It clones it and returns a new instance with the modified
     * query builder, so the original reference is preserved.
     *
     * @return $this
     */
    protected function filter(callable $filter): self
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder);

        return $cloned;
    }

    /**
     * Returns a cloned instance of the query builder.
     *
     * Use this to perform single result queries.
     */
    protected function query(): QueryBuilder
    {
        return clone $this->queryBuilder;
    }

    /**
     * We allow cloning only from this scope.
     * Also, we clone the query builder always.
     */
    protected function __clone()
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }
}
