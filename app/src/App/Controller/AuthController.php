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

use Exception;
use Twig\Environment;
use Psr\Log\LoggerInterface;
use D6\Invoice\App\Auth\AuthService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthController
 */
class AuthController
{
    public function __construct(private Environment $twig, private AuthService $authService, private LoggerInterface $logger)
    {
    }

    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function loginAction(Request $request): string
    {
        return $this->twig->render('auth/login.html.twig');
    }

    /**
     * Destroy session and go back home
     */
    public function logoutAction()
    {
    }
}
