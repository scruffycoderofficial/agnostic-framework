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

use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\EventListener\ExpressionLanguage;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(Workflow::class)
            ->args([
                abstract_arg('workflow definition'),
                abstract_arg('marking store'),
                service('event_dispatcher')->ignoreOnInvalid(),
                abstract_arg('workflow name'),
                abstract_arg('events to dispatch'),
            ])
            ->abstract()

        ->set(StateMachine::class)
            ->args([
                abstract_arg('workflow definition'),
                abstract_arg('marking store'),
                service('event_dispatcher')->ignoreOnInvalid(),
                abstract_arg('workflow name'),
                abstract_arg('events to dispatch'),
            ])
            ->abstract()

        ->set(MethodMarkingStore::class)
            ->abstract()

        ->set(Registry::class)

        ->set(ExpressionLanguage::class);
};
