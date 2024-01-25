<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @see https://twig.symfony.com/doc/3.x/api.html
 */
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(FilesystemLoader::class)
        ->args(['resources/views', '%root_dir%'])
        ->public();

    $services->set(Environment::class)
        ->args([
            service(FilesystemLoader::class),
            [
                'cache' => '%root_dir%/bootstrap/cache/views',
                'debug' => getenv('APP_DEBUG'),
            ],
        ])
        ->public();
};
