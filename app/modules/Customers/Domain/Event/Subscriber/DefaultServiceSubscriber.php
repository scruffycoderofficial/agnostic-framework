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

namespace CoolStuff\Customers\Domain\Event\Subscriber;

use CoolStuff\Customers\Domain\Service\CustomerService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CoolStuff\Customers\Domain\Service\DefaultCustomerService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

final class DefaultServiceSubscriber implements ServiceSubscriber, ContainerAwareInterface
{
    protected ContainerInterface $container;

    public function setContainer(ContainerInterface $container = null)
    {
        if (is_null($container)) {
            throw new \Exception('The subscriber requires a ContainerInterface as a dependency.');
        }

        $this->container = $container;
    }

    public static function getSubscribedServices(): array
    {
        return [
            CustomerService::class => DefaultCustomerService::class,
        ];
    }
}
