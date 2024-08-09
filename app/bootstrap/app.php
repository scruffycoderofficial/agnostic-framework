<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\App\CompilerPass\ProductsWebScraperCompilerPass;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Craue\FormFlowBundle\DependencyInjection\CraueFormFlowExtension;
use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Craue\FormFlowBundle\DependencyInjection\Compiler\LegacySessionCompilerPass;

$container = new ContainerBuilder();

$loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../config'));

if (class_exists(RuntimeInstantiator::class) && method_exists($container, 'setProxyInstantiator')) {
    $container->setProxyInstantiator(new RuntimeInstantiator());
}

try {
    $loader->load('parameters.php');
    $loader->load('console.php');
    $loader->load('doctrine.php');
    $loader->load('monolog.php');

    /* Core framework configurations */
    $loader->load('kernel.php');
    $loader->load('session.php');
    $loader->load('events.php');

    /* Application framework configurations */
    $loader->load('app.php');
    $loader->load('mail.php');
    $loader->load('console.php');
    $loader->load('goutte.php');
    $loader->load('events.php');
    $loader->load('forms.php');
    $loader->load('views.php');
    $loader->load('dompdf.php');
    $loader->load('doctrine.php');
    $loader->load('migrations.php');
    $loader->load('fixtures.php');
    $loader->load('security.php');

    $loader->load('products.php');
    $loader->load('repositories.php');
    $loader->load('services.php');
    $loader->load('controllers.php');
} catch (Exception $exc) {
} finally {
    $container->addCompilerPass(new ProductsWebScraperCompilerPass());

    if (! \method_exists(RequestStack::class, 'getSession')) {
        $container->addCompilerPass(new LegacySessionCompilerPass());
    }

    /**
    $container->registerExtension((function () use ($container) {
        $craueFormFlowExtension = new CraueFormFlowExtension();
        $craueFormFlowExtension->load([], $container);

        return $craueFormFlowExtension;
    })());*/
}

if (! $container->isCompiled()) {
    $container->compile(true);
}

return $container;
