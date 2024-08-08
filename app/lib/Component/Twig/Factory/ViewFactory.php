<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Twig\Factory;

use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Symfony\Component\Form\FormRenderer;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ViewFactory.
 *
 * @package CoolStuff\Component\Twig\Factory
 */
final class ViewFactory implements ServiceSubscriberInterface
{
    public static function createEnvironment(ContainerBuilder $containerBuilder, LoaderInterface $loader, array $options): Environment
    {
        $symfonyAppVariableClass = '\Symfony\Bridge\Twig\AppVariable';
        if (class_exists($symfonyAppVariableClass)) {
            $loader->addPath(dirname((new \ReflectionClass($symfonyAppVariableClass))->getFileName()));
        }

        $twig = new Environment($loader, $options);

        $twig->addRuntimeLoader(new FactoryRuntimeLoader([
            FormRenderer::class => function () use ($containerBuilder) {
                return $containerBuilder->get(FormRenderer::class);
            }])
        );

        return $twig;
    }

    public static function getSubscribedServices(): array
    {
        return [
            FormRenderer::class => FormRenderer::class,
        ];
    }
}
