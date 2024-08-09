<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Console;

use Symfony\Component\Console\Application as SymfonyApplication;

/**
 * Class Application.
 *
 * @package CoolStuff\Component\Console
 */
class Application extends SymfonyApplication
{
    /**
     * Application constructor.
     */
    public function __construct(iterable $commands = null)
    {
        $commands = $commands instanceof \Traversable ? \iterator_to_array($commands) : $commands;

        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct(getenv('APP_NAME'), '0.0.1');
    }
}
