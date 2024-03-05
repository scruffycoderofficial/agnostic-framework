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

use CoolStuff\App\Entity\User;

/**
 * Interface UserRepositoryInterface.
 */
interface UserRepositoryInterface
{
    /**
     * @return iterable
     */
    public function all(): iterable;

    /**
     * @param int $userId
     * @return User|null
     */
    public function ofId(int $userId): ?User;

    /**
     * @param string $email
     * @return User|null
     */
    public function ofEmail(string $email): ?User;
}
