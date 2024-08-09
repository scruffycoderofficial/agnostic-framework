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

namespace CoolStuff\Component\Foundation\Concern;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Interface EventListenerProviderInterface.
 *
 * @package CoolStuff\Component\Foundation\Concern
 */
interface EventListenerProviderInterface
{
    public function subscribe(ContainerBuilder $containerBuilder, EventDispatcherInterface $eventDispatcher);
}
