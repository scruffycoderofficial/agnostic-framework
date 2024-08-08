<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\Component\Foundation\Concern;

use CoolStuff\Component\Foundation\Application;

/**
 * Interface BootableProviderInterface.
 *
 * @package CoolStuff\Component\Foundation\Concern
 */
interface BootableProviderInterface
{
    public function boot(Application $app);
}
