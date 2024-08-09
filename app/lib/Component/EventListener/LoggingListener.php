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

use Exception;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class LoggingListener.
 *
 * @package CoolStuff\Component\EventListener
 */
final class LoggingListener implements EventSubscriberInterface
{
    /**
     * LoggingListener constructor.
     *
     * @param null $loggingFilter
     */
    public function __construct(private LoggerInterface $logger, private $loggingFilter = null)
    {
        if (null === $loggingFilter) {
            $this->loggingFilter = function (\Exception $e) {
                if ($e instanceof HttpExceptionInterface && $e->getStatusCode() < 500) {
                    return LogLevel::ERROR;
                }

                return LogLevel::CRITICAL;
            };
        }
    }

    /**
     * @param ResponseEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $this->logRequest($event->getRequest());
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $this->logResponse($event->getResponse());
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $e = $event->getThrowable();

        $this->logger->log(call_user_func($this->loggingFilter, $e), sprintf('%s: %s (uncaught exception) at %s line %s', get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()), ['exception' => $e]);
    }

    /**
     * @return array[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
            KernelEvents::RESPONSE => ['onKernelResponse', 0],
            KernelEvents::EXCEPTION => ['onKernelException', -4],
        ];
    }

    /**
     * Logs a request.
     */
    protected function logRequest(Request $request)
    {
        $this->logger->log(LogLevel::DEBUG, '> '.$request->getMethod().' '.$request->getRequestUri());
    }

    /**
     * Logs a response.
     */
    protected function logResponse(Response $response)
    {
        $message = '< '.$response->getStatusCode();

        if ($response instanceof RedirectResponse) {
            $message .= ' '.$response->getTargetUrl();
        }

        $this->logger->log(LogLevel::DEBUG, $message);
    }

    /**
     * Logs an exception.
     */
    protected function logException(\Exception $e)
    {
        $this->logger->log(call_user_func($this->loggingFilter, $e), sprintf('%s: %s (uncaught exception) at %s line %s', get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()), ['exception' => $e]);
    }
}
