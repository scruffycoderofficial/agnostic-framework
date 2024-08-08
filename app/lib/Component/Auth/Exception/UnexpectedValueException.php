<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Auth\Exception;

use UnexpectedValueException as BaseUnexpectedValueException;

/**
 * Class UnexpectedValueException.
 *
 * @package CoolStuff\Component\Auth\Exception
 */
class UnexpectedValueException extends BaseUnexpectedValueException implements ExceptionInterface
{
}
