<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\App\Controller;

use Twig\Environment;
use PhpSpec\ObjectBehavior;
use D6\Invoice\App\Controller\InvoiceReports;

class InvoiceReportsSpec extends ObjectBehavior
{
    public function let(Environment $environment)
    {
        $this->beConstructedWith($environment);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InvoiceReports::class);
    }
}
