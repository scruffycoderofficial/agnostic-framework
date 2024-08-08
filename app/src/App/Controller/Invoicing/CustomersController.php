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

namespace CoolStuff\App\Controller\Invoicing;

use Symfony\Component\HttpFoundation\Response;
use CoolStuff\Invoicing\Domain\Entity\Customer;
use CoolStuff\Component\Controller\AbstractController;
use CoolStuff\Invoicing\Domain\Repository\CustomerRepository;
use CoolStuff\Invoicing\Shared\Specification\Customer\CustomerSpecification;

/**
 * Class CustomersController.
 *
 * @package CoolStuff\App\Controller\Invoicing
 */
final class CustomersController extends AbstractController
{
    public function __construct(protected CustomerRepository $customerRepository)
    {
    }

    public function indexAction(): string
    {
        return $this->render('invoicing/customers/list.html.twig', [
            'customers' => $this->customerRepository
                ->getAll(),
        ]);
    }

    public function newAction(): string|Response
    {
        if ($this->getRequest()->isMethod('POST')) {
            $customer = (new Customer())
                ->setName($this->getRequest()->request->get('name'))
                ->setEmail($this->getRequest()->request->get('email'));

            $newCustomerSpec = new CustomerSpecification();

            if ($newCustomerSpec->isSatisfiedBy($customer)) {
                $this->customerRepository->persist($customer);
            }
        }

        return $this->redirectAction($this->getRequest(), $this->urlGenerator()
            ->generate('st_customers')
        );
    }
}
