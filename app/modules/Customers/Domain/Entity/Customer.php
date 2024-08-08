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

namespace CoolStuff\Customers\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use PHPMentors\DomainKata\Entity\EntityInterface;

#[ORM\Entity]
#[ORM\Table(name: 'customers')]
final class Customer extends Entity implements EntityInterface
{
    #[ORM\Column(name: 'name')]
    protected string $name;

    #[ORM\Column(name: 'email')]
    protected string $email;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
