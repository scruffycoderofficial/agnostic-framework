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

namespace CoolStuff\Partners\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'partners_group')]
class Group extends Entity
{
    #[ORM\ManyToOne(targetEntity: Partner::class)]
    protected Collection $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }
}
