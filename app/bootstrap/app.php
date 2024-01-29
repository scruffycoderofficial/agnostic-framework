<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$container = new ContainerBuilder();

$loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../config'));

$loader->load('parameters.php');
$loader->load('monolog.php');
$loader->load('kernel.php');
$loader->load('session.php');
$loader->load('events.php');

$loader->load('app.php');
$loader->load('console.php');
$loader->load('database.php');
$loader->load('forms.php');
$loader->load('views.php');
$loader->load('dompdf.php');

if (! $container->isCompiled()) {
    $container->compile();
}

return $container;
