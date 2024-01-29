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
use Symfony\Component\Form\FormRenderer;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use Symfony\Bridge\Twig\Extension\FormExtension;
use D6\Invoice\Component\Twig\Extension\AppExtension;
use D6\Invoice\Component\Twig\Extension\MoneyExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

/**
 * @see https://twig.symfony.com/doc/3.x/api.html
 */
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(AppExtension::class);

    $services->set(MoneyExtension::class);

    $services->set(TranslationExtension::class);

    $services->set(FormExtension::class);

    $services->set(FactoryRuntimeLoader::class)
        ->arg('$map', [FormRenderer::class]);

    $services->set(FilesystemLoader::class)
        ->args(['resources/views', '%app.root_dir%'])
        ->call('addPath', ['%vendor.twig_bridge.dir%/Resources/views/Form'])
        ->public();

    $services->set(Environment::class)
        ->args([
            service(FilesystemLoader::class),
            [
                'cache' => '%app.root_dir%/var/cache/views',
                'debug' => getenv('APP_DEBUG'),
                'twig.strict_variables' => true,
            ],
        ])
        ->call('addRuntimeLoader', [service(FactoryRuntimeLoader::class)])
        ->call('addExtension', [service(AppExtension::class)])
        ->call('addExtension', [service(MoneyExtension::class)])
        ->call('addExtension', [service(TranslationExtension::class)])
        ->call('addExtension', [service(FormExtension::class)])
        ->public();
};
