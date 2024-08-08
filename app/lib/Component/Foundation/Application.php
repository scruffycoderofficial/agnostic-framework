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

namespace CoolStuff\Component\Foundation;

use CoolStuff\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use CoolStuff\Component\Foundation\Concern\BootableProviderInterface;
use CoolStuff\Component\Foundation\Concern\EventListenerProviderInterface;

/**
 * Class Application.
 *
 * @package CoolStuff\Component\Foundation
 */
final class Application implements HttpKernelInterface, TerminableInterface
{
    const EARLY_EVENT = 512;

    const LATE_EVENT = -512;

    /**
     * @var array List of modular Service Provider implementation to
     *            hide ContainerBuilder configuration's not so intuitive process
     */
    protected array $providers = [];

    /**
     * @var bool Whether the application has been booted
     */
    protected bool $booted = false;

    /**
     * Application constructor.
     */
    public function __construct(private ContainerBuilder $containerBuilder)
    {
    }

    /**
     * If you call this method directly instead of run(), you must call the
     * terminate() method yourself, if you want the finish filters to be run.
     */
    public function handle(Request $request, $type = HttpKernelInterface::MAIN_REQUEST, $catch = true): Response
    {
        if (! $this->booted) {
            $this->boot();
        }

        return $this->containerBuilder
            ->get(Kernel::class)
            ->handle($request, $type, $catch);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->containerBuilder
            ->get(Kernel::class)
            ->terminate($request, $response);
    }

    public function addServiceProvider($provider)
    {
        $this->providers[] = $provider;
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;

        if (! empty($this->providers)) {
            foreach ($this->providers as $provider) {
                if ($provider instanceof EventListenerProviderInterface) {
                    $eventDispatcher = new EventDispatcher();
                    if ($this->containerBuilder->has(EventDispatcherInterface::class)) {
                        $eventDispatcher = $this->containerBuilder
                            ->get(EventDispatcherInterface::class);
                    }
                    $provider->subscribe($this->containerBuilder, $eventDispatcher);
                }

                if ($provider instanceof BootableProviderInterface) {
                    $provider->boot($this);
                }
            }
        }

        if (! $this->containerBuilder->isCompiled()) {
            $this->containerBuilder->compile();
        }
    }

    public function run(Request $request = null)
    {
        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);

        $response->send();

        $this->terminate($request, $response);
    }

    public function getContainer(): ContainerBuilder
    {
        return $this->containerBuilder;
    }
}
