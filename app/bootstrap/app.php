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
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use CoolStuff\App\DependencyInjection\CompilerPass\ProductsWebScraperCompilerPass;

$container = new ContainerBuilder();

/*
 * Sets ProxyManager to allow for managing Lazy services
 */
if (class_exists(RuntimeInstantiator::class) && method_exists($container, 'setProxyInstantiator')) {
    $container->setProxyInstantiator(new RuntimeInstantiator());
}

/**
 * Setup PHP File Loader.
 */
$loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../config'));

try {
    /* Configuration parameters */
    $loader->load('parameters.php');

    /* Application business configurations */
    $loader->load('products.php');

    /*
     * External service configurations
     */
    $loader->load('goutte.php');
    $loader->load('monolog.php');

    /* Core framework configurations */
    $loader->load('kernel.php');
    $loader->load('session.php');
    $loader->load('events.php');

    /* Application framework configurations */
    $loader->load('app.php');
    $loader->load('console.php');

    $loader->load('forms.php');
    $loader->load('views.php');
    $loader->load('dompdf.php');
    $loader->load('doctrine.php');
    $loader->load('migrations.php');
    $loader->load('fixtures.php');
} catch (Exception $exc) {
} finally {
    /* Add CompilerPassInterface definitions */
    $container->addCompilerPass(new ProductsWebScraperCompilerPass());

    /*
     * Compile Container, if not compiled already
     */
    if (! $container->isCompiled()) {
        $container->compile();
    }
}

return $container;
