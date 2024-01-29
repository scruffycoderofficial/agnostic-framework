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

use DateTime;
use Money\Money;

/**
 * Class Order
 */
class Order
{
    public function __construct(
        private int $id,
        private int $userId,
        private DateTime $dateReceived,
        private string $receiverName,
        private string $receiverAddress,
        private Money $totalBeforeTax,
        private Money $totalTax,
        private int $taxPer,
        private Money $totalAfterTax,
        private Money $amountPaid,
        private Money $totalAmountDue,
        private string $note
    ) {
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
     * @return Order
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Order
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateReceived(): DateTime
    {
        return $this->dateReceived;
    }

    /**
     * @param DateTime $dateRecieved
     * @return Order
     */
    public function setDateReceived(DateTime $dateReceived): self
    {
        $this->dateReceived = $dateRecieved;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverName(): string
    {
        return $this->receiverName;
    }

    /**
     * @param string $recieverName
     * @return Order
     */
    public function setReceiverName(string $receiverName): self
    {
        $this->receiverName = $receiverName;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverAddress(): string
    {
        return $this->receiverAddress;
    }

    /**
     * @param string $recieverAddress
     * @return Order
     */
    public function setReceiverAddress(string $receiverAddress): self
    {
        $this->receiverAddress = $recieverAddress;

        return $this;
    }

    /**
     * @return Money
     */
    public function getTotalBeforeTax(): Money
    {
        return $this->totalBeforeTax;
    }

    /**
     * @param Money $totalBeforeTax
     * @return Order
     */
    public function setTotalBeforeTax(Money $totalBeforeTax): self
    {
        $this->totalBeforeTax = $totalBeforeTax;

        return $this;
    }

    /**
     * @return Money
     */
    public function getTotalTax(): Money
    {
        return $this->totalTax;
    }

    /**
     * @param Money $totalTax
     * @return Order
     */
    public function setTotalTax(Money $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaxPer(): int
    {
        return $this->taxPer;
    }

    /**
     * @param int $taxPer
     * @return Order
     */
    public function setTaxPer(int $taxPer): self
    {
        $this->taxPer = $taxPer;

        return $this;
    }

    /**
     * @return Money
     */
    public function getTotalAfterTax(): Money
    {
        return $this->totalAfterTax;
    }

    /**
     * @param Money $totalAfterTax
     * @return Order
     */
    public function setTotalAfterTax(Money $totalAfterTax): self
    {
        $this->totalAfterTax = $totalAfterTax;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAmountPaid(): Money
    {
        return $this->amountPaid;
    }

    /**
     * @param Money $amountPaid
     * @return Order
     */
    public function setAmountPaid(Money $amountPaid): self
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    /**
     * @return Money
     */
    public function getTotalAmountDue(): Money
    {
        return $this->totalAmountDue;
    }

    /**
     * @param Money $totalAmountDue
     * @return Order
     */
    public function setTotalAmountDue(Money $totalAmountDue): self
    {
        $this->totalAmountDue = $totalAmountDue;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return Order
     */
    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
