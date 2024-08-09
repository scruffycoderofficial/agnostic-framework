<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\CoolStuff\Invoicing\Domain\Service;

use PhpSpec\ObjectBehavior;
use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Invoicing\Domain\Entity\Customer;
use CoolStuff\Invoicing\Domain\Factory\InvoiceFactory;
use CoolStuff\Invoicing\Domain\Service\InvoicingService;
use CoolStuff\Invoicing\Domain\Repository\OrderRepository;

/**
 * Class InvoicingServiceSpec.
 *
 * @package spec\CoolStuff\Invoicing\Domain\Service
 */
class InvoicingServiceSpec extends ObjectBehavior
{
    public function let(OrderRepository $orderRepository)
    {
        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@acme-corp.co.za');

        $orderRepository
            ->getUnInvoicedOrders()
            ->willReturn([
                (new Order())
                    ->setCustomer($customer)
                    ->setDescription('Bought Carling Black Label on credit @ R60 (excl. VAT) for 2.')
                    ->setRefNumber('20240329-2010-8748')
                    ->setTotal(60.0),
                (new Order())
                    ->setCustomer($customer)
                    ->setDescription('Bought Carling Black Label on credit @ R30 (excl. VAT) for 1.')
                    ->setRefNumber('20240402-2010-8768')
                    ->setTotal(30.0),
            ]);

        $this->beConstructedWith($orderRepository, new InvoiceFactory());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InvoicingService::class);
    }

    public function it_generates_invoices()
    {
        $this->generateInvoices()->shouldBeArray();
    }
}
