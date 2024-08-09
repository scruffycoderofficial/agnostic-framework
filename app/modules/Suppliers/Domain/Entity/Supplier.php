<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Suppliers\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use Doctrine\Common\Collections\Collection;
use CoolStuff\Shared\Entity\Location\Address;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'supplier_suppliers')]
class Supplier extends Entity
{
    #[ORM\Column(name: 'name')]
    private string $name;

    #[ORM\Column(name: 'license_number')]
    private string $licenseNumber;

    #[ORM\Column(name: 'telephone')]
    private string $telephone;

    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'supplier_addresses', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'suppliers_supplier_addresses')]
    #[ORM\JoinColumn(name: 'supplier_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'suppliers_supplier_address_id', referencedColumnName: 'id')]
    private $addresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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

    public function getLicenseNumber(): string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(string $licenseNumber): self
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function hasAddresses(): bool
    {
        return $this->addresses->isEmpty();
    }

    /**
     * @return Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function setAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            return $this;
        }

        $this->addresses->add($address);

        return $this;
    }

    public function removeAddress(Address $address): self|null
    {
        if (! $this->addresses->contains($address)) {
            return $this;
        }

        $this->addresses->remove($address);

        return $this;
    }
}
