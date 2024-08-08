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

use Money\Money;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class OrderItem.
 *
 * @package CoolStuff\App\Common\Entity
 */
class OrderItem implements EntityInterface
{
    public function __construct(
        private int $id,
        private int $orderId,
        private string $itemCode,
        private string $itemName,
        private int $orderItemQuantity,
        private Money $orderItemUnitPrice,
        private Money $orderItemTotalCost)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getItemCode(): string
    {
        return $this->itemCode;
    }

    public function setItemCode(string $itemCode): self
    {
        $this->itemCode = $itemCode;

        return $this;
    }

    public function setOrderItemName(string $itemName): self
    {
        $this->itemName = $itemName;
    }

    public function getOrderItemName(): string
    {
        return $this->itemName;
    }

    public function getOrderItemQuantity(): int
    {
        return $this->orderItemQuantity;
    }

    public function setOrderItemQuantity(int $orderItemQuantity): self
    {
        $this->orderItemQuantity = $orderItemQuantity;

        return $this;
    }

    public function getOrderItemUnitPrice(): Money
    {
        return $this->orderItemUnitPrice;
    }

    public function setOrderItemUnitPrice(Money $orderItemUnitPrice): self
    {
        $this->orderItemUnitPrice = $orderItemUnitPrice;

        return $this;
    }

    public function getOrderItemTotalCost(): Money
    {
        return $this->orderItemTotalCost;
    }

    public function setOrderItemTotalCost(Money $orderItemTotalCost): self
    {
        $this->orderItemTotalCost = $orderItemTotalCost;

        return $this;
    }
}
