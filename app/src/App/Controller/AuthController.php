<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\App\Controller;

use Twig\Environment;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthController.
 *
 * @package CoolStuff\App\Controller
 */
class AuthController
{
    public function __construct(private Environment $twig, private LoggerInterface $logger)
    {
    }

    /**
     * @throws \Exception
     */
    public function loginAction(Request $request): string
    {
        return $this->twig->render('auth/login.html.twig');
    }

    /**
     * Destroy session and go back home.
     */
    public function logoutAction()
    {
    }
}
