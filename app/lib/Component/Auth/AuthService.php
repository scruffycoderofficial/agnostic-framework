<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Auth;

/**
 * Class AuthService.
 *
 * @package CoolStuff\Component\Auth
 */
class AuthService implements AuthServiceInterface
{
    public function authenticate(): RequestResult
    {
        // TODO: Implement authenticate() method.
    }

    public function hasIdentity(): bool
    {
        // TODO: Implement hasIdentity() method.
    }

    public function getIdentity(): mixed
    {
        // TODO: Implement getIdentity() method.
    }

    public function clearIdentity(): void
    {
        // TODO: Implement clearIdentity() method.
    }
}
