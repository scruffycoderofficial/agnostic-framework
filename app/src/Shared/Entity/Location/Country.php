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

namespace CoolStuff\Shared\Entity\Location;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;

#[ORM\Entity]
#[ORM\Table(name: 'supplier_countries')]
class Country extends Entity
{
    #[ORM\Column(type: 'string')]
    private string $code;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
