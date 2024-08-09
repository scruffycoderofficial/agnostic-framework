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

namespace CoolStuff\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use PHPMentors\DomainKata\Entity\EntityInterface;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
#[ORM\HasLifecycleCallbacks]
class Product extends Entity implements EntityInterface
{
    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $tagline;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string')]
    private string $brand;

    #[ORM\Column(type: 'boolean')]
    private bool $is_active = false;

    #[ORM\Column(type: 'date', nullable: true)]
    private \DateTime $last_collected_on;

    #[ORM\ManyToOne(targetEntity: 'SupplierProductPrice', inversedBy: 'product_price')]
    private SupplierProductPrice $product_price;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTagline(): string
    {
        return $this->tagline;
    }

    public function setTagline(string $tagline): self
    {
        $this->tagline = $tagline;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getLastCollectedOn(): \DateTime
    {
        return $this->last_collected_on;
    }

    /**
     * @PrePersist
     */
    public function setLastCollectedOn(\DateTime $dateTime): self
    {
        $this->last_collected_on = $dateTime;

        return $this;
    }
}
