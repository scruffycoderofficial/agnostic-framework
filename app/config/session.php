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

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(NativeFileSessionHandler::class)
        ->arg('$savePath', '%app.session.handler_path%');

    $services->set(NativeSessionStorage::class)
        ->args([[], service(NativeFileSessionHandler::class)]);

    $services->set(Session::class)
        ->arg('$storage', service(NativeSessionStorage::class))
        ->call('set', ['admin_email', '%app.session.admin_email%'])
        ->call('start')
        ->public();
};
