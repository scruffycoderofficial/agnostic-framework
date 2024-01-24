<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Console;

use Traversable;
use Symfony\Component\Console\Application as SymfonyApplication;
use function iterator_to_array;

/**
 * Class Application
 */
class Application extends SymfonyApplication
{
    /**
     * Application constructor.
     *
     * @param iterable|null $commands
     */
    public function __construct(iterable $commands = null)
    {
        $commands = $commands instanceof Traversable ? iterator_to_array($commands) : $commands;

        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct(getenv('APP_NAME'), '0.0.1');
    }
}
