<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Twig\Environment;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    /*
     * Generates safe Uri based token used for uniquely
     * identifying forms
     */
    $services->set(UriSafeTokenGenerator::class);

    /*
     * Natively stores generated session tokens for each form
     */
    $services->set(NativeSessionTokenStorage::class);

    /*
     * Csrf Token Manager responsible for managing Form sessions
     */
    $services->set(CsrfTokenManager::class)
        ->args([
            service(UriSafeTokenGenerator::class),
            service(NativeSessionTokenStorage::class),
        ]);

    /*
     * Enables extension to support Symfony Validator component in forms
     */
    $services->set(Validation::class)
        ->factory([Validation::class, 'createValidator']);

    /*
     * Loader specific to loading translations from XLIFF files.
     */
    $services->set(XliffFileLoader::class);

    /*
     * Translation service encapsulating relevant loaders and resources
     */
    $services->set(Translator::class)
        ->arg('$locale', '%app.locale%')
        ->call('addLoader', ['xlf', service(XliffFileLoader::class)])
        ->call('addResource', ['xlf', '%vendor.form_dir%/Resources/translations/validators.en.xlf', 'en', 'validators'])
        ->call('addResource', ['xlf',  '%vendor.validator.dir%/Resources/translations/validators.en.xlf', 'en', 'validators']);

    /*
     * Twig-based renderer engine with Bootstrap 5 Layout
     * template support
     */
    $services->set(TwigRendererEngine::class)
        ->args([
            ['%app.forms.default_theme%', 'bootstrap_5_layout.html.twig'],
            service(Environment::class),
        ]);

    /*
     * Renders a form into HTML using a rendering engine.
     */
    $services->set(FormRenderer::class)
        ->arg('$engine', service(TwigRendererEngine::class))
        ->arg('$csrfTokenManager', service(CsrfTokenManager::class))
        ->public();

    /*
     * This extension protects forms by using a CSRF token.
     */
    $services->set(CsrfExtension::class)
        ->arg('$tokenManager', service(CsrfTokenManager::class))
        ->public();

    /*
     * Provides integration of the Translation component with Twig
     */
    $services->set(TranslationExtension::class)
        ->arg('$translator', service(Translator::class));

    /*
     * The FormExtension extends Twig with form capabilities.
     */
    $services->set(FormExtension::class)
        ->arg('$translator', service(Translator::class));

    /*
     * HttpFoundationExtension integrates the HttpFoundation
     * component with the Form component.
     */
    $services->set(HttpFoundationExtension::class);

    /*
     * ValidatorExtension supports the Symfony Validator component
     * in forms.
     */
    $services->set(ValidatorExtension::class)
        ->arg('$validator', service(Validation::class));

    /*
     * The default implementation of FormFactoryBuilderInterface used
     * to build forms for display within Client screens.
     */
    $services->set(FormFactoryBuilder::class)
        ->factory([Forms::class, 'createFormFactoryBuilder'])
        ->call('addExtension', [service(HttpFoundationExtension::class)])
        ->call('addExtension', [service(CsrfExtension::class)])
        ->call('addExtension', [service(ValidatorExtension::class)]);
};
