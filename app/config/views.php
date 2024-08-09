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
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use CoolStuff\Component\Twig\Factory\ViewFactory;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Bridge\Twig\Extension\WebLinkExtension;
use CoolStuff\Component\Twig\Extension\AppExtension;
use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use CoolStuff\Component\Twig\Extension\MoneyExtension;
use Symfony\Bridge\Twig\Extension\HttpKernelExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Extension\HttpFoundationExtension;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

/*
 * @see https://twig.symfony.com/doc/3.x/api.html
 */
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(AppExtension::class);

    $services->set(MoneyExtension::class);

    $services->set(TranslationExtension::class);

    $services->set(FormExtension::class);

    $services->set(RoutingExtension::class)
        ->arg('$generator', service('url_generator'));

    $services->set(WebLinkExtension::class)
        ->arg('$requestStack', service('request_stack'));

    $services->set(HttpKernelExtension::class);

    $services->set(HttpFoundationExtension::class)
        ->arg('$urlHelper', service(UrlHelper::class));

    $services->set(HttpKernelRuntime::class)
        ->arg('$handler', service(FragmentHandler::class));

    $services->set(FilesystemLoader::class)
        ->args(['resources/views', '%app.root_dir%'])
        ->call('addPath', ['%vendor.twig_bridge.dir%/Resources/views/Form'])
        ->public();

    $services->set(ViewFactory::class);

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
        ->call('addExtension', [service(RoutingExtension::class)])
        ->call('addExtension', [service(WebLinkExtension::class)])
        ->call('addExtension', [service(HttpKernelExtension::class)])
        ->call('addExtension', [service(HttpFoundationExtension::class)])
        ->public();
};
