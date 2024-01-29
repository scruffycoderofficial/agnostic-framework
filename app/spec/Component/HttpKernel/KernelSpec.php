<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\Component\HttpKernel;

use PhpSpec\ObjectBehavior;
use D6\Invoice\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

/**
 * Class KernelSpec
 */
class KernelSpec extends ObjectBehavior
{
    public function let(EventDispatcherInterface $eventDispatcher, ControllerResolverInterface $controllerResolver)
    {
        $this->beConstructedWith($eventDispatcher, $controllerResolver);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Kernel::class);
    }

    public function it_is_an_http_kernel_type()
    {
        $this->shouldBeAnInstanceOf(HttpKernel::class);
    }
}
