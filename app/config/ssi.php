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

use Symfony\Component\HttpKernel\HttpCache\Ssi;
use Symfony\Component\HttpKernel\EventListener\SurrogateListener;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(Ssi::class)

        ->set(SurrogateListener::class)
            ->args([service('coolstuff.ssi')->ignoreOnInvalid()])
            ->tag('kernel.event_subscriber');
};
