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

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * @return iterable|User[]
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
