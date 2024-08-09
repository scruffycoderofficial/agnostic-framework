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
#[ORM\Table(name: 'invoice_receipts')]
final class Invoice extends Entity
{
    #[ORM\Column(name: 'date_issued')]
    protected \DateTime $dateIssued;

    #[ORM\Column(name: 'total', precision: 10, scale: 2)]
    protected float $total;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'invoices')]
    protected Order $order;

    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return Order
     */
    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getDateIssued(): \DateTime
    {
        return $this->dateIssued;
    }

    /**
     * @return $this
     */
    public function setDateIssued(\DateTime $dateIssued): self
    {
        $this->dateIssued = $dateIssued;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @return Order
     */
    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
