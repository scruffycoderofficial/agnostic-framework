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

use Twig\Environment;
use Symfony\Component\Form\Forms;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class AbstractController.
 *
 * @package CoolStuff\Component\Controller
 */
abstract class AbstractController implements ServiceSubscriberInterface
{
    protected ContainerInterface $container;

    private ?int $httpPort;

    private ?int $httpsPort;

    #[Required]
    public function setContainer(ContainerInterface $container): ?ContainerInterface
    {
        $previous = $this->container ?? null;
        $this->container = $container;

        return $previous;
    }

    public static function getSubscribedServices(): array
    {
        return [
            Environment::class => Environment::class,
            'url_generator' => UrlGenerator::class,
            Request::class => Request::class,
        ];
    }

    /**
     * Redirects to another route with the given name.
     *
     * The response status code is 302 if the permanent parameter is false (default),
     * and 301 if the redirection is permanent.
     *
     * In case the route name is empty, the status code will be 404 when permanent is false
     * and 410 otherwise.
     *
     * @param string     $route             The route name to redirect to
     * @param bool       $permanent         Whether the redirection is permanent
     * @param bool|array $ignoreAttributes  Whether to ignore attributes or an array of attributes to ignore
     * @param bool       $keepRequestMethod Whether redirect action should keep HTTP request method
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function redirectAction(Request $request, string $route, bool $permanent = false, bool|array $ignoreAttributes = false, bool $keepRequestMethod = false, bool $keepQueryParams = false): Response
    {
        if ('' == $route) {
            throw new HttpException($permanent ? 410 : 404);
        }

        $attributes = [];
        if (false === $ignoreAttributes || \is_array($ignoreAttributes)) {
            $attributes = $request->attributes->get('_route_params');

            if ($keepQueryParams) {
                if ($query = $request->server->get('QUERY_STRING')) {
                    $query = HeaderUtils::parseQuery($query);
                } else {
                    $query = $request->query->all();
                }

                $attributes = array_merge($query, $attributes);
            }

            unset($attributes['route'], $attributes['permanent'], $attributes['ignoreAttributes'], $attributes['keepRequestMethod'], $attributes['keepQueryParams']);
            if ($ignoreAttributes) {
                $attributes = array_diff_key($attributes, array_flip($ignoreAttributes));
            }
        }

        if ($keepRequestMethod) {
            $statusCode = $permanent ? 308 : 307;
        } else {
            $statusCode = $permanent ? 301 : 302;
        }

        return new RedirectResponse(
            $this->container
                ->get('url_generator')
                ->generate($route, $attributes, UrlGeneratorInterface::ABSOLUTE_URL),
            $statusCode
        );
    }

    /**
     * Redirects to a URL.
     *
     * The response status code is 302 if the permanent parameter is false (default),
     * and 301 if the redirection is permanent.
     *
     * In case the path is empty, the status code will be 404 when permanent is false
     * and 410 otherwise.
     *
     * @param string      $path              The absolute path or URL to redirect to
     * @param bool        $permanent         Whether the redirect is permanent or not
     * @param string|null $scheme            The URL scheme (null to keep the current one)
     * @param int|null    $httpPort          The HTTP port (null to keep the current one for the same scheme or the default configured port)
     * @param int|null    $httpsPort         The HTTPS port (null to keep the current one for the same scheme or the default configured port)
     * @param bool        $keepRequestMethod Whether redirect action should keep HTTP request method
     *
     * @throws HttpException In case the path is empty
     */
    public function urlRedirectAction(Request $request, string $path, bool $permanent = false, string $scheme = null, int $httpPort = null, int $httpsPort = null, bool $keepRequestMethod = false): Response
    {
        if ('' == $path) {
            throw new HttpException($permanent ? 410 : 404);
        }

        if ($keepRequestMethod) {
            $statusCode = $permanent ? 308 : 307;
        } else {
            $statusCode = $permanent ? 301 : 302;
        }

        // redirect if the path is a full URL
        if (parse_url($path, \PHP_URL_SCHEME)) {
            return new RedirectResponse($path, $statusCode);
        }

        $scheme ??= $request->getScheme();

        if ($qs = $request->server->get('QUERY_STRING') ?: $request->getQueryString()) {
            if (! str_contains($path, '?')) {
                $qs = '?'.$qs;
            } else {
                $qs = '&'.$qs;
            }
        }

        $port = '';
        if ('http' === $scheme) {
            if (null === $httpPort) {
                if ('http' === $request->getScheme()) {
                    $httpPort = $request->getPort();
                } else {
                    $httpPort = $this->httpPort;
                }
            }

            if (null !== $httpPort && 80 != $httpPort) {
                $port = ":$httpPort";
            }
        } elseif ('https' === $scheme) {
            if (null === $httpsPort) {
                if ('https' === $request->getScheme()) {
                    $httpsPort = $request->getPort();
                } else {
                    $httpsPort = $this->httpsPort;
                }
            }

            if (null !== $httpsPort && 443 != $httpsPort) {
                $port = ":$httpsPort";
            }
        }

        $url = $scheme.'://'.$request->getHost().$port.$request->getBaseUrl().$path.$qs;

        return new RedirectResponse($url, $statusCode);
    }

    protected function getRequest()
    {
        return $this->container->get(Request::class);
    }

    protected function urlGenerator()
    {
        return $this->container->get('url_generator');
    }

    protected function render(string $name, array $data = []): string
    {
        return $this->container->get(Environment::class)
            ->render($name, $data);
    }

    /**
     * Gets a container parameter by its name.
     */
    protected function getParameter(string $name): array|bool|string|int|float|null
    {
        if (! $this->container->has('parameter_bag')) {
            throw new ServiceNotFoundException('parameter_bag.', null, null, [], sprintf('The "%s::getParameter()" method is missing a parameter bag to work properly. Did you forget to register your controller as a service subscriber? This can be fixed either by using autoconfiguration or by manually wiring a "parameter_bag" in the service locator passed to the controller.', static::class));
        }

        return $this->container->get('parameter_bag')->get($name);
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     */
    protected function createForm(string $type, mixed $data = null, array $options = []): FormInterface
    {
        return Forms::createFormFactory()->create($type, $data, $options);
    }
}
