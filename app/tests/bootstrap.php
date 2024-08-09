<?php

use Symfony\Component\Dotenv\Dotenv;

try {

    /**
     * Enforce Global Variable loading for testing
     * environment from dot env file(s)
     */
    (new Dotenv())
        ->overload(__DIR__ . '/../.env.testing');

} catch (Exception $exc) {

    throw new Exception("Could not globally overload environment variables.");
}
