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

use Psr\Log\LoggerInterface;
use D6\Invoice\App\Auth\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LeapYearsController
 */
class AuthController
{
    public function __construct(private AuthService $authService, private LoggerInterface $logger)
    {
    }

    /**
     * @param Request $request
     * @return string
     */
    public function login(Request $request): Response
    {
        return new Response('We will show the HTML Form for the User to login with here.');
    }
}
