<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Model;

use Money\Money;

/**
 * Class OrderItem
 *
 * @package D6\Invoice\App\Model
 */
class OrderItem
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrderItem
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return OrderItem
     */
    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemCode(): string
    {
        return $this->itemCode;
    }

    /**
     * @param string $itemCode
     * @return OrderItem
     */
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

    /**
     * @return int
     */
    public function getOrderItemQuantity(): int
    {
        return $this->orderItemQuantity;
    }

    /**
     * @param int $orderItemQuantity
     * @return OrderItem
     */
    public function setOrderItemQuantity(int $orderItemQuantity): self
    {
        $this->orderItemQuantity = $orderItemQuantity;

        return $this;
    }

    /**
     * @return Money
     */
    public function getOrderItemUnitPrice(): Money
    {
        return $this->orderItemUnitPrice;
    }

    /**
     * @param Money $orderItemUnitPrice
     * @return OrderItem
     */
    public function setOrderItemUnitPrice(Money $orderItemUnitPrice): self
    {
        $this->orderItemUnitPrice = $orderItemUnitPrice;

        return $this;
    }

    /**
     * @return Money
     */
    public function getOrderItemTotalCost(): Money
    {
        return $this->orderItemTotalCost;
    }

    /**
     * @param Money $orderItemTotalCost
     * @return OrderItem
     */
    public function setOrderItemTotalCost(Money $orderItemTotalCost): self
    {
        $this->orderItemTotalCost = $orderItemTotalCost;

        return $this;
    }
}
