<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\Component\Logger;

use PhpSpec\ObjectBehavior;
use D6\Invoice\Component\Logger\LoggerDecorator;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerDecoratorSpec
 *
 * @package spec\D6\Invoice\Component\Logger
 */
class LoggerDecoratorSpec extends ObjectBehavior
{
    function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LoggerDecorator::class);
    }
}
