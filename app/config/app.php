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

use Symfony\Component\Mailer\Transport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Command\MailerTestCommand;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('request', Request::class)
        ->factory([Request::class, 'createFromGlobals'])
        ->public();

    $services->set('response', Response::class)
        ->public();

    $services->set('default_mail_transport', Transport::class)
        ->factory([Transport::class, 'fromDsn'])
        ->arg('$dsn', '%app.mailing.mailer_dsn%');

    $services->set(MailerTestCommand::class)
        ->arg('$transport', service(Transport::class))
        ->tag('console.command');
};
