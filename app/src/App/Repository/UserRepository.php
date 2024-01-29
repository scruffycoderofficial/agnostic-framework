<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Repository;

use D6\Invoice\App\Model\User;
use D6\Invoice\Component\Repository\DbalRepository;

/**
 * Class UserRepository
 */
class UserRepository extends DbalRepository implements UserRepositoryInterface
{
    public function all(): iterable
    {
        $result = $this->queryBuilder->select('*')->from('users')->fetchAllAssociative();

        $users = [];
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
        } else {
            return null;
        }
    }

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
        } else {
            return null;
        }
    }
}
