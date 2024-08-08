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
#[ORM\Table(name: 'supplier_product_prices')]
final class SupplierProductPrice extends Entity implements EntityInterface
{
    #[ORM\Column(type: 'float')]
    protected float $previousPrice;

    #[ORM\Column(type: 'float')]
    protected float $currentPrice;

    #[ORM\Column(type: 'float', nullable: true)]
    protected float $newPrice;

    #[ORM\OneToMany(mappedBy: 'id', targetEntity: 'Supplier')]
    protected Supplier $supplier;

    #[ORM\OneToMany(mappedBy: 'id', targetEntity: 'Product')]
    protected Product $product;

    public function getPreviousPrice(): float
    {
        return $this->previousPrice;
    }

    public function setPreviousPrice(float $previousPrice): self
    {
        $this->previousPrice = $previousPrice;

        return $this;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function setCurrentPrice(float $currentPrice): self
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    public function getNewPrice(): float
    {
        return $this->newPrice;
    }

    public function setNewPrice(float $newPrice): self
    {
        $this->newPrice = $newPrice;

        return $this;
    }

    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
