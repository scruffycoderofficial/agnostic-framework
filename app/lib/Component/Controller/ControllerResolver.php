<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\Component\Controller;

use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;

/**
 * Class ControllerResolver.
 *
 * @package CoolStuff\Component\Controller
 */
final class ControllerResolver extends ContainerControllerResolver
{
    protected function instantiateController(string $class): object
    {
        $controller = parent::instantiateController($class);

        if ($controller instanceof AbstractController) {
            if (null === $previousContainer = $controller->setContainer($this->container)) {
                throw new \LogicException(sprintf('"%s" has no container set, did you forget to define it as a service subscriber?', $class));
            } else {
                $controller->setContainer($previousContainer);
            }
        }

        return $controller;
    }
}
