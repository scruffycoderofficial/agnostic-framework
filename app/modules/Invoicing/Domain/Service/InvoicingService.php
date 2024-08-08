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

namespace CoolStuff\Invoicing\Domain\Service;

use CoolStuff\Invoicing\Domain\Factory\InvoiceFactory;
use CoolStuff\Invoicing\Domain\Repository\OrderRepository;

/**
 * Class InvoicingService.
 *
 * @package CoolStuff\Invoicing\Domain\Service
 */
final class InvoicingService
{
    /**
     * InvoicingService constructor.
     */
    public function __construct(protected OrderRepository $orderRepository, protected InvoiceFactory $invoiceFactory)
    {
    }

    /**
     * @return Invoice[]
     */
    public function generateInvoices(): array
    {
        $orders = $this->orderRepository
            ->getUnInvoicedOrders();

        $invoices = [];

        if (! empty($orders)) {
            foreach ($orders as $order) {
                $invoices[] = $this->invoiceFactory
                    ->createFromOrder($order);
            }
        }

        return $invoices;
    }
}
