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

namespace CoolStuff\Invoicing\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use CoolStuff\Customers\Domain\Entity\Customer;

#[ORM\Entity]
#[ORM\Table(name: 'invoice_orders')]
final class Order extends Entity
{
    #[ORM\Column(name: 'reference_number')]
    protected string $refNumber;

    #[ORM\Column(name: 'description')]
    protected string $description;

    #[ORM\Column(name: 'total', precision: 10, scale: 2)]
    protected float $total;

    #[ORM\ManyToOne(targetEntity: Customer::class, cascade: ['persist', 'remove'], inversedBy: 'orders')]
    protected Customer $customer;

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getRefNumber(): string
    {
        return $this->refNumber;
    }

    public function setRefNumber(string $refNumber): self
    {
        $this->refNumber = $refNumber;

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

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
