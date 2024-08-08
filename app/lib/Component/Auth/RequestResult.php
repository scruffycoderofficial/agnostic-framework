<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Auth;

/**
 * Class RequestResult.
 *
 * @package CoolStuff\Component\Auth
 */
class RequestResult
{
    const TYPES = [
        'FAILURE' => 0,
        'FAILURE_IDENTITY_NOT_FOUND' => -1,
        'FAILURE_IDENTITY_AMBIGUOUS' => -2,
        'FAILURE_CREDENTIAL_INVALID' => -3,
        'FAILURE_UNCATEGORIZED' => -4,
        'SUCCESS' => 1,
    ];

    public function __construct(protected int $code, protected $identity, protected array $messages = [])
    {
    }

    /**
     * Returns whether the request result represents a successful authentication attempt.
     */
    public function isValid(): bool
    {
        return $this->code > 0;
    }

    /**
     * Gets the request result code for this authentication attempt.
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Returns the identity used in the authentication attempt.
     */
    public function getIdentity(): mixed
    {
        return $this->identity;
    }

    /**
     * Returns an array of string reasons why the authentication attempt was unsuccessful.
     *
     * If authentication was successful, this method returns an empty array.
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
