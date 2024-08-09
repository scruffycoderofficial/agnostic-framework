<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Bridge\Twig\Extension\FormExtension;
use CoolStuff\Component\Twig\Factory\ViewFactory;
use CoolStuff\Component\Twig\Extension\AppExtension;
use CoolStuff\Component\Twig\Extension\MoneyExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

/*
 * @see https://twig.symfony.com/doc/3.x/api.html
 */
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    /*
     * An extension to handle date/time conversion to human
     * readable text e.g. few minutes ago or a day ago
     */
    $services->set(AppExtension::class);

    /*
     * Helps format Money
     */
    $services->set(MoneyExtension::class);

    /*
     * Integrates Symfony Translation component with Twig.
     */
    $services->set(TranslationExtension::class);

    /*
     * Extend Twig with Symfony forms capabilities.
     */
    $services->set(FormExtension::class);

    /*
     * Template loader from the filesystem.
     */
    $services->set(FilesystemLoader::class)
        ->args(['resources/views', '%app.root_dir%'])
        ->call('addPath', ['%vendor.twig_bridge.dir%/Resources/views/Form'])
        ->public();

    /*
     * Custom Twig Factory to add required FormRenderer
     */
    $services->set(ViewFactory::class);

    /*
     * Stores the Twig configuration and renders templates.
     */
    $services->set(Environment::class)
        ->args([
            service('service_container'),
            service(FilesystemLoader::class),
            [
                'cache' => '%app.root_dir%/var/cache/views',
                'debug' => getenv('APP_DEBUG'),
                'twig.strict_variables' => true,
            ],
        ])
        ->factory([ViewFactory::class, 'createEnvironment'])
        ->call('addExtension', [service(AppExtension::class)])
        ->call('addExtension', [service(MoneyExtension::class)])
        ->call('addExtension', [service(TranslationExtension::class)])
        ->call('addExtension', [service(FormExtension::class)])
        ->public();
};
