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
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use CoolStuff\App\Email\SignupMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(BodyRenderer::class)
        ->arg('$twig', service(Environment::class))
        ->alias(BodyRendererInterface::class, BodyRenderer::class);

    $services->set(MessageListener::class)
        ->args([
            null,
            service(BodyRendererInterface::class),
        ]);

    $services->set(Transport::class)
        ->factory([Transport::class, 'fromDsn'])
        ->arg('$dsn', '%app.mailing.mailer_dsn%');

    $services->set(Mailer::class)
        ->arg('$transport', service(Transport::class))
        ->arg('$bus', null)
        ->arg('$dispatcher', service(EventDispatcherInterface::class));

    $services->set(Email::class);

    $services->set(TemplatedEmail::class);

    $services->set(SignupMailer::class)
        ->arg('$templatedEmail', service(TemplatedEmail::class));
};
