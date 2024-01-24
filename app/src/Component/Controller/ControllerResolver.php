<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;

/**
 * Class ControllerResolver
 * s
 */
class ControllerResolver extends ContainerControllerResolver
{
    public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
    {
        parent::__construct($container, $logger);
    }

    /**
     * Returns a callable for the given controller.
     *
     * @throws \InvalidArgumentException When the controller cannot be created
     */
    protected function createController(string $controller): callable
    {
        if (! str_contains($controller, '@')) {
            $controller = $this->instantiateController($controller);

            if (! \is_callable($controller)) {
                throw new \InvalidArgumentException($this->getControllerError($controller));
            }

            return $controller;
        }

        [$class, $method] = explode('::', $controller, 2);

        try {
            $controller = [$this->instantiateController($class), $method];
        } catch (\Error|\LogicException $e) {
            try {
                if ((new \ReflectionMethod($class, $method))->isStatic()) {
                    return $class.'::'.$method;
                }
            } catch (\ReflectionException) {
                throw $e;
            }

            throw $e;
        }

        if (! \is_callable($controller)) {
            throw new \InvalidArgumentException($this->getControllerError($controller));
        }

        return $controller;
    }

    /**
     * @inheritdoc
     */
    protected function instantiateController($class): object
    {
        return parent::instantiateController($class);
    }

    private function getControllerError(mixed $callable): string
    {
        if (\is_string($callable)) {
            if (str_contains($callable, '::')) {
                $callable = explode('::', $callable, 2);
            } else {
                return sprintf('Function "%s" does not exist.', $callable);
            }
        }

        if (\is_object($callable)) {
            $availableMethods = $this->getClassMethodsWithoutMagicMethods($callable);
            $alternativeMsg = $availableMethods ? sprintf(' or use one of the available methods: "%s"', implode('", "', $availableMethods)) : '';

            return sprintf('Controller class "%s" cannot be called without a method name. You need to implement "__invoke"%s.', get_debug_type($callable), $alternativeMsg);
        }

        if (! \is_array($callable)) {
            return sprintf('Invalid type for controller given, expected string, array or object, got "%s".', get_debug_type($callable));
        }

        if (! isset($callable[0]) || ! isset($callable[1]) || 2 !== \count($callable)) {
            return 'Invalid array callable, expected [controller, method].';
        }

        [$controller, $method] = $callable;

        if (\is_string($controller) && ! class_exists($controller)) {
            return sprintf('Class "%s" does not exist.', $controller);
        }

        $className = \is_object($controller) ? get_debug_type($controller) : $controller;

        if (method_exists($controller, $method)) {
            return sprintf('Method "%s" on class "%s" should be public and non-abstract.', $method, $className);
        }

        $collection = $this->getClassMethodsWithoutMagicMethods($controller);

        $alternatives = [];

        foreach ($collection as $item) {
            $lev = levenshtein($method, $item);

            if ($lev <= \strlen($method) / 3 || str_contains($item, $method)) {
                $alternatives[] = $item;
            }
        }

        asort($alternatives);

        $message = sprintf('Expected method "%s" on class "%s"', $method, $className);

        if (\count($alternatives) > 0) {
            $message .= sprintf(', did you mean "%s"?', implode('", "', $alternatives));
        } else {
            $message .= sprintf('. Available methods: "%s".', implode('", "', $collection));
        }

        return $message;
    }

    private function getClassMethodsWithoutMagicMethods($classOrObject): array
    {
        $methods = get_class_methods($classOrObject);

        return array_filter($methods, fn (string $method) => 0 !== strncmp($method, '__', 2));
    }
}
