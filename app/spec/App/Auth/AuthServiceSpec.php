<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\App\Auth;

use PhpSpec\ObjectBehavior;
use D6\Invoice\App\Auth\AuthService;
use D6\Invoice\App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class AuthServiceSpec
 *
 * @package spec\D6\Invoice\App\Auth
 */
class AuthServiceSpec extends ObjectBehavior
{
    public function let(UserRepositoryInterface $userRepository)
    {
        $this->beConstructedWith($userRepository, new Request());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AuthService::class);
    }
}
