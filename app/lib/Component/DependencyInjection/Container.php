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

namespace CoolStuff\Component\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class Container.
 *
 * @package CoolStuff\Component\DependencyInjection
 */
final class Container extends ContainerBuilder
{
    public function __construct(ParameterBagInterface $parameterBag = null)
    {
        parent::__construct($parameterBag);

        /*
         * Should not be necessary as the RuntimeInstantiator
         * class is deprecated as of 6.3. This feature will be
         * removed post initial release of this platform.
         */
        if (class_exists(RuntimeInstantiator::class) && method_exists($this, 'setProxyInstantiator')) {
            $this->setProxyInstantiator(new RuntimeInstantiator());
        }

        $this->loadResourceConfigs();
    }

    private function loadResourceConfigs()
    {
        $loader = new PhpFileLoader($this, new FileLocator(__DIR__.'/../Resources/config'));

        try {
            /*
             * Presentation layer related configurations
             */
            $loader->load('views.php');
            $loader->load('forms.php');
        } catch (\Exception $exc) {
            // Handle thrown exception the best way
        }
    }
}
