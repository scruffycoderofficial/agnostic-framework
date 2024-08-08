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

namespace CoolStuff\Invoicing\Tests\Unit\Domain\Service;

use PHPUnit\Framework\TestCase;
use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Customers\Domain\Entity\Customer;
use CoolStuff\Invoicing\Domain\Factory\InvoiceFactory;
use CoolStuff\Invoicing\Domain\Service\InvoicingService;
use CoolStuff\Invoicing\Domain\Repository\OrderRepository;

/**
 * Class InvoicingServiceTest.
 *
 * @package CoolStuff\Invoicing\Tests\Domain\Service
 */
final class InvoicingServiceTest extends TestCase
{
    public function testItCanCreateInvoices()
    {
        $invoicingService = new InvoicingService($this->orderRepository(), new InvoiceFactory());

        $invoices = $invoicingService->generateInvoices();

        self::assertSame(60.0, $invoices[0]->getTotal());
        self::assertSame(30.0, $invoices[1]->getTotal());
    }

    protected function orderRepository(): OrderRepository
    {
        $orderRepository = $this->getMockBuilder(OrderRepository::class)
            ->onlyMethods([
                'getById',
                'getAll',
                'persist',
                'begin',
                'commit',
                'getUnInvoicedOrders',
            ])
            ->getMock();

        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@acme-corp.co.za');

        $firstOrder = (new Order())
            ->setCustomer($customer)
            ->setDescription('Bought Carling Black Label on credit @ R60 (excl. VAT) for 2.')
            ->setRefNumber('20240329-2010-8748')
            ->setTotal(60.00);

        $secondOrder = (new Order())
            ->setCustomer($customer)
            ->setDescription('Bought Carling Black Label on credit @ R30 (excl. VAT) for 1.')
            ->setRefNumber('20240402-2010-8768')
            ->setTotal(30.00);

        $orderRepository->expects($this->once())
            ->method('getUnInvoicedOrders')
            ->willReturn([$firstOrder, $secondOrder]);

        return $orderRepository;
    }
}
