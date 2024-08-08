<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Auth\Adapter;

use CoolStuff\Component\Auth\RequestResult;
use CoolStuff\Component\Auth\Adapter\Exception\ExceptionInterface;

/**
 * Interface AdapterInterface.
 *
 * @package CoolStuff\Component\Auth\Adapter
 */
interface AdapterInterface
{
    /**
     * @throws ExceptionInterface If authentication cannot be performed
     */
    public function authenticate(): RequestResult;
}
