<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\Component\Controller;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use D6\Invoice\Component\Controller\ControllerResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ControllerResolverSpec
 */
class ControllerResolverSpec extends ObjectBehavior
{
    public function let(LoggerInterface $logger)
    {
        $this->beConstructedWith(new ContainerBuilder(), $logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ControllerResolver::class);
    }
}
