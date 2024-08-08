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

namespace CoolStuff\Partners\Tests\Functional;

use CoolStuff\Shared\Tests\Doctrine\EntityTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Component\Testing\Concern\InteractsWithDatabase;
use CoolStuff\Component\Testing\Concern\InteractsWithFixtures;

/**
 * Class TestCase.
 *
 * @package CoolStuff\Partners\Tests\Functional
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

    public function testItIsInTestingEnvironmentMode()
    {
        self::assertTrue('testing' === getenv('APP_ENV'));
    }

    public function testItUsesTestingDatabase()
    {
        self::assertTrue('coolstuff_solutions_testing_db' === getenv('DB_DATABASE'));
    }

    abstract protected function entityClasses(): array;
}
