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
 * Interface AuthServiceInterface.
 *
 * @package CoolStuff\Component\Auth
 */
interface AuthServiceInterface
{
    /**
     * Authenticates and provides an authentication result.
     */
    public function authenticate(): RequestResult;

    /**
     * Returns true if and only if an identity is available.
     */
    public function hasIdentity(): bool;

    /**
     * Returns the authenticated identity or null if no identity is available.
     */
    public function getIdentity(): mixed;

    /**
     * Clears the identity.
     */
    public function clearIdentity(): void;
}
