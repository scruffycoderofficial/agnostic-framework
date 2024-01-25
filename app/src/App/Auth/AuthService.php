<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Auth;

use D6\Invoice\App\Model\User;
use D6\Invoice\App\Repository\UserRepositoryInterface;

/**
 * Class AuthService
 */
class AuthService
{
    public function __construct(private UserRepositoryInterface $users)
    {
    }

    public function getAuthoriseable(string $email)
    {
        return $this->users->ofEmail($email);
    }

    public function authorise(User $user)
    {
        return true;
    }
}
