<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\App\Repository;

use Iterator;
use Doctrine\DBAL\Exception;
use CoolStuff\App\Entity\User;
use CoolStuff\Component\Repository\Repository;
use PHPMentors\DomainKata\Entity\EntityInterface;
use CoolStuff\Component\Repository\DbalRepository;

/**
 * Class UserRepository.
 */
class UserRepository extends DbalRepository implements UserRepositoryInterface
{
    public function all(): iterable
    {
        $users = [];

        $result = $this->queryBuilder->select('*')->from('users')->fetchAllAssociative();

        array_map(function ($entry) use ($users) {
            array_push($users, new User(
                $entry['id'],
                $entry['first_name'],
                $entry['last_name'],
                $entry['email'],
                $entry['mobile'],
                $entry['address'],
                $entry['password']
            ));
        }, $result);

        return $users;
    }

    public function ofId(int $userId): ?User
    {
        $result = $this->queryBuilder
            ->select('id', 'first_name', 'last_name', 'email', 'mobile', 'address', 'password')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $userId)
            ->fetchAllAssociative();

        if (! is_null($result)) {
            return new User(
                $result[0]['id'],
                $result[0]['first_name'],
                $result[0]['last_name'],
                $result[0]['email'],
                $result[0]['mobile'],
                $result[0]['address'],
                $result[0]['password']
            );
        }
    }

    /**
     * @param string $email
     * @return User|null
     * @throws Exception
     */
    public function ofEmail(string $email): ?User
    {
        $result = $this->queryBuilder
            ->select('id', 'first_name', 'last_name', 'email', 'mobile', 'address', 'password')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)
            ->fetchAllAssociative();

        if (! is_null($result)) {
            return new User(
                $result[0]['id'],
                $result[0]['first_name'],
                $result[0]['last_name'],
                $result[0]['email'],
                $result[0]['mobile'],
                $result[0]['address'],
                $result[0]['password']
            );
        }
    }

    public function getIterator(): Iterator
    {
        // TODO: Implement getIterator() method.
    }

    public function slice(int $start, int $size = 20): \CoolStuff\Component\Repository\Repository
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
}
