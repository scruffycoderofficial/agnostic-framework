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

use Goutte\Client;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    /*
     * Web Scraping Client service
     */
    $services->set(Client::class);
};
