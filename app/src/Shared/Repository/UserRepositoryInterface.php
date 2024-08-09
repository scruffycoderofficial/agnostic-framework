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
use PHPMentors\DomainKata\Repository\RepositoryInterface;

/**
 * Interface UserRepositoryInterface.
 *
 * @package CoolStuff\Common\Repository
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function all(): iterable;

    public function ofId(int $userId): ?User;

    public function ofEmail(string $email): ?User;
}
