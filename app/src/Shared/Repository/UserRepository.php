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

namespace CoolStuff\Shared\Repository;

use CoolStuff\Shared\Entity\User;
use PHPMentors\DomainKata\Entity\EntityInterface;
use CoolStuff\Component\Repository\Contract\ORMRepository;
use CoolStuff\Component\Repository\Doctrine\DoctrineORMRepository;

/**
 * Class UserRepository.
 */
class UserRepository extends DoctrineORMRepository implements UserRepositoryInterface
{
    public function getIterator(): \Iterator
    {
        // TODO: Implement getIterator() method.
    }

    public function slice(int $start, int $size = 20): ORMRepository
    {
        // TODO: Implement slice() method.
    }

    public function count(): int
    {
        // TODO: Implement count() method.
    }

    public function add(EntityInterface $entity)
    {
        // TODO: Implement add() method.
    }

    public function remove(EntityInterface $entity)
    {
        // TODO: Implement remove() method.
    }

    public function all(): iterable
    {
        // TODO: Implement all() method.
    }

    public function ofId(int $userId): ?User
    {
        // TODO: Implement ofId() method.
    }

    public function ofEmail(string $email): ?User
    {
        // TODO: Implement ofEmail() method.
    }
}
