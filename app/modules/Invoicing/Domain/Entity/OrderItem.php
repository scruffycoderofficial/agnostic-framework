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

#[ORM\Entity]
#[ORM\Table(name: 'invoice_order_items')]
final class OrderItem extends Entity
{
    #[ORM\Column(name: 'code', type: 'string')]
    private string $code;

    #[ORM\Column(name: 'name', type: 'string')]
    private string $name;

    #[ORM\Column(name: 'quantity', type: 'integer')]
    private int $quantity;

    #[ORM\Column(name: 'price', precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column(name: 'total_amount', precision: 10, scale: 2)]
    private float $totalAmount;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
}
