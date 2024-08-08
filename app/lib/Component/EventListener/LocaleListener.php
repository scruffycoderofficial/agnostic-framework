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

namespace CoolStuff\Component\EventListener;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LocaleListener.
 *
 * @package CoolStuff\Component\EventListener
 */
final class LocaleListener implements EventSubscriberInterface
{
    private ContainerBuilder $container;

    public function __construct(ContainerInterface $container, private RequestStack $requestStack, private RequestContext $requestContext, private string $defaultLocale = 'en')
    {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $request->setDefaultLocale($this->defaultLocale);

        $this->setLocale($request);
        $this->setRouterContext($request);

        // $this->container->setParameter('app.locale', $request->getLocale());
    }

    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        if (null !== $parentRequest = $this->requestStack->getParentRequest()) {
            $this->setRouterContext($parentRequest);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 16]],
            KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]],
        ];
    }

    private function setLocale(Request $request)
    {
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        }
    }

    private function setRouterContext(Request $request)
    {
        if (null !== $this->requestContext) {
            $this->requestContext->setParameter('_locale', $request->getLocale());
        }
    }
}
