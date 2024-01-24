<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\HttpKernel\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class StringResponseListener
 */
class StringResponseListener implements EventSubscriberInterface
{
    /**
     * @param ViewEvent $event
     */
    public function onView(ViewEvent $event): void
    {
        $response = $event->getControllerResult();

        if (is_string($response)) {
            $event->setResponse(new Response($response));
        }
    }

    /** @inheritDoc */
    public static function getSubscribedEvents(): array
    {
        return ['kernel.view' => 'onView'];
    }
}
