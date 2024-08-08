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

namespace CoolStuff\Shared\Tests\Functional\Entity\People;

use CoolStuff\Shared\Entity\People\User;
use CoolStuff\Shared\Entity\People\UserGroup;
use CoolStuff\Shared\Tests\Functional\TestCase;

final class UserTest extends TestCase
{
    protected function entityClasses(): array
    {
        return [User::class, UserGroup::class];
    }

    public function testItCanPersistAUserWithAGroup()
    {
        $userGroup = new UserGroup();

        $user = (new User())
            ->addUserGroup($userGroup);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        self::assertSame(1, $user->getId());

        self::assertInstanceOf(UserGroup::class, $this->entityManager
            ->getRepository(UserGroup::class)
            ->find(1)
        );
    }
}
