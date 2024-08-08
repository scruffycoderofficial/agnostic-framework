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

namespace CoolStuff\Shared\Entity\People;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity()]
#[ORM\Table(name: 'people_user_groups')]
class UserGroup extends Entity
{
    #[ORM\ManyToMany(targetEntity: 'User', mappedBy: 'userGroups')]
    protected Collection $users;

    /**
     * Default constructor, initializes collections.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
        // $user->addUserGroup($this);
    }

    public function removeUser(User $user)
    {
        if (! $this->users->contains($user)) {
            return;
        }

        $this->users->removeElement($user);
        // $user->removeUserGroup($this);
    }
}
