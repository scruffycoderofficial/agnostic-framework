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
#[ORM\Table(name: 'supplier_addresses')]
class Address extends Entity
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $street;

    #[ORM\Column(type: 'string', length: 255)]
    private string $suburb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: 'string', length: 255)]
    private string $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(name: 'postal_code', type: 'string', length: 255)]
    private string $postalCode;

    #[ORM\ManyToOne(targetEntity: Country::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Country $country;

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getSuburb(): string
    {
        return $this->suburb;
    }

    public function setSuburb(string $suburb): self
    {
        $this->suburb = $suburb;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
