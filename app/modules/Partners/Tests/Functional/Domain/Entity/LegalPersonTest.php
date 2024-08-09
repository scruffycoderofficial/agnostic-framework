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

namespace CoolStuff\Partners\Tests\Functional\Domain\Entity;

use CoolStuff\Partners\Domain\Entity\Partner;
use CoolStuff\Partners\Domain\Entity\LegalPerson;
use CoolStuff\Partners\Tests\Functional\TestCase;

/**
 * Class LegalPersonTest.
 *
 * @package CoolStuff\Partners\Tests\Functional\Domain\Entity
 */
final class LegalPersonTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testItCanPersistALegalPerson()
    {
        $naturalPerson = (new LegalPerson())
            ->setName('Mandy Doe');

        $this->entityManager->persist($naturalPerson);
        $this->entityManager->flush();

        self::assertSame(1, $naturalPerson->getId());
        self::assertSame('Mandy Doe', $naturalPerson->getName());
    }

    protected function entityClasses(): array
    {
        return [Partner::class, LegalPerson::class];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
