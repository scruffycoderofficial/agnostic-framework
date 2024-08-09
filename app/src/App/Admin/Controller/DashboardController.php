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

namespace CoolStuff\App\Admin\Controller;

/**
 * Class DashboardController.
 *
 * @package CoolStuff\App\Admin\Controller
 */
final class DashboardController
{
    public function indexAction(): string
    {
        return "As much as I am disabled from the service configuration file's point of view, I am still useful from the routing's perspective.";
        // return $this->render('admin/dashboard.html.twig');
    }
}
