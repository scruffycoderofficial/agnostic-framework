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

namespace CoolStuff\Shared\Entity\ProductType;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable()]
final class UnitMeasure
{
    public function __construct(
        #[ORM\Column(name: 'type', type: 'string')]
        private string $type,
        #[ORM\Column(name: 'capacity', type: 'string')]
        private string $capacity,
        #[ORM\Column(name: 'value', type: 'string')]
        private string $measure)
    {
    }

    public function __toString(): string
    {
        return sprintf('%s - %s%s', strtolower($this->type), $this->capacity, strtolower($this->measure));
    }
}
