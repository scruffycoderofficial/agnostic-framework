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
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity()]
#[ORM\Table(name: 'people_users')]
class User extends Entity
{
    #[ORM\ManyToMany(targetEntity: 'UserGroup', inversedBy: 'users', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'usergroup_id', referencedColumnName: 'id')]
    protected $userGroups;

    /**
     * Default constructor, initializes collections.
     */
    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
    }

    public function addUserGroup(UserGroup $userGroup)
    {
        if ($this->userGroups->contains($userGroup)) {
            return;
        }

        $this->userGroups->add($userGroup);
        $userGroup->addUser($this);

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup)
    {
        if (! $this->userGroups->contains($userGroup)) {
            return;
        }

        $this->userGroups->removeElement($userGroup);
        $userGroup->removeUser($this);
    }
}
