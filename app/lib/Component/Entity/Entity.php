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

namespace CoolStuff\Component\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass()]
abstract class Entity
{
    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue()]
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
