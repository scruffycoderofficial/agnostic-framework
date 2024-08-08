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
use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;
use PHPMentors\DomainKata\Entity\EntityInterface;

#[ORM\Entity()]
#[ORM\Table(name: 'orders')]
class Order extends Entity implements EntityInterface
{
    #[ORM\Column(name: 'date_received')]
    protected \DateTime $dateReceived;

    #[ORM\Column(name: 'received_by')]
    protected string $receivedBy;

    #[ORM\Column(name: 'receiver_address')]
    protected string $receiverAddress;

    #[ORM\Embedded(class: 'CoolStuff\Component\Entity\Type\Money')]
    protected Money $totalTax;

    #[ORM\Embedded(class: 'CoolStuff\Component\Entity\Type\Money')]
    protected Money $totalAmountDue;

    #[ORM\Column(name: 'note')]
    protected string $note;

    #[ORM\OneToOne(mappedBy: 'user', inversedBy: 'id', targetEntity: User::class)]
    protected User $user;

    public function getDateReceived(): \DateTime
    {
        return $this->dateReceived;
    }

    public function setDateReceived(\DateTime $dateReceived): self
    {
        $this->dateReceived = $dateReceived;

        return $this;
    }

    public function getReceiverBy(): string
    {
        return $this->receivedBy;
    }

    public function setReceiverName(string $receivedBy): self
    {
        $this->receivedBy = $receivedBy;

        return $this;
    }

    public function getReceiverAddress(): string
    {
        return $this->receiverAddress;
    }

    public function setReceiverAddress(string $receiverAddress): self
    {
        $this->receiverAddress = $receiverAddress;

        return $this;
    }

    public function getTotalTax(): Money
    {
        return $this->totalTax;
    }

    public function setTotalTax(Money $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function getTotalAmountDue(): Money
    {
        return $this->totalAmountDue;
    }

    public function setTotalAmountDue(Money $totalAmountDue): self
    {
        $this->totalAmountDue = $totalAmountDue;

        return $this;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
