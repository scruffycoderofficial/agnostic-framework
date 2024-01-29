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

use Exception;
use D6\Invoice\App\Model\User;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Request;
use D6\Invoice\App\Repository\UserRepositoryInterface;

/**
 * Class AuthService
 */
class AuthService
{
    /**
     * Key string used to identify user's presence from
     * within his browsers session.
     */
    public const AUTH_SESSION_KEY = 'user_email';

    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $users
     * @param Request $request
     */
    public function __construct(private UserRepositoryInterface $users, private Request $request)
    {
    }

    /**
     * Gets the User by username/email
     *
     * @param string $email
     * @return User
     */
    public function getAuthUser(string $email): User
    {
        return $this->users->ofEmail($email);
    }

    /**
     * Authorises a user inorder to grant access into the system
     *
     * @param User $user
     * @param $password
     * @return bool
     * @throws Exception
     */
    public function authorise(User $user, $password): Boolean
    {
        if ($password === $user->getPassword()) {
            $this->logUserIn($this->request, $user);
        } else {
            throw new Exception('Please enter correct credentials or contact your System Administrator.');
        }
    }

    /**
     * Revokes user access until they log back in
     */
    public function unAuthorise(): void
    {
        $this->request->getSession()->invalidate(0);
    }

    /**
     * Checks whether given user is authorised already
     *
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function isAuthorised(User $user): bool
    {
        if ($authorised = $user->getEmail() !== $request->getSession()->get(self::AUTH_SESSION_KEY)) {
            if (! $request->getSession()->getFlashBag()->has('auth.error')) {
                throw new Exception('Invalid credentials provided. Please enter correct login details.');
            }
        }

        return $authorised;
    }

    /**
     * Authorises a user, giving system's entry capability
     *
     * @param Request $request
     * @param User $user
     */
    protected function logUserIn(Request $request, User $user)
    {
        $request->getSession()->set(self::AUTH_SESSION_KEY, $user->getEmail());
    }
}
