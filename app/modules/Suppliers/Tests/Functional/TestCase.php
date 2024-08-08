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

namespace CoolStuff\Suppliers\Tests\Functional;

use CoolStuff\Shared\Tests\Doctrine\EntityTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Component\Testing\Concern\InteractsWithDatabase;
use CoolStuff\Component\Testing\Concern\InteractsWithFixtures;

/**
 * Class TestCase.
 *
 * @package CoolStuff\Suppliers\Tests\Functional
 */
abstract class TestCase extends EntityTestCase
{
    use InteractsWithDatabase;
    use InteractsWithFixtures;

    protected static ContainerBuilder $container;

    public function setContainer(): void
    {
        $container = include_once __DIR__.'/../../../../bootstrap/app.php';

        /* Helps delay Container assignment to the static property of this test case */
        if ($container instanceof ContainerBuilder) {
            static::$container = $container;
        }
    }

    abstract protected function entityClasses(): array;
}
