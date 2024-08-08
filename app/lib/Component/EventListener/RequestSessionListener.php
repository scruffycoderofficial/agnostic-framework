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

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RequestSessionListener.
 *
 * @package CoolStuff\Component\EventListener
 */
final class RequestSessionListener implements EventSubscriberInterface
{
    public function __construct(private Session $session)
    {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (! $request->hasSession()) {
            $request->setSession($this->session);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
