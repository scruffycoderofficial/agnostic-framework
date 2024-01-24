<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Controller;

use Twig\Environment;

class InvoiceReports
{
    public function __construct(private Environment $twig)
    {
    }

    public function listAction()
    {
        return $this->twig->render('reports/list.html.twig');
    }
}
