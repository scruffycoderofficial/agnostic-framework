<?php
/*
 * This file is part of the D6 Assessment Project.
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

    $services->set(UriSafeTokenGenerator::class);

    $services->set(NativeSessionTokenStorage::class);

    $services->set(CsrfTokenManager::class)
        ->args([
            service(UriSafeTokenGenerator::class),
            service(NativeSessionTokenStorage::class),
        ]);

    $services->set(Validation::class)
        ->factory([Validation::class, 'createValidator']);

    $services->set(XliffFileLoader::class);

    $services->set(Translator::class)
        ->arg('$locale', '%app.locale%')
        ->call('addLoader', ['xlf', service(XliffFileLoader::class)])
        ->call('addResource', ['xlf', '%vendor.form_dir%/Resources/translations/validators.en.xlf', 'en', 'validators'])
        ->call('addResource', ['xlf',  '%vendor.validator.dir%/Resources/translations/validators.en.xlf', 'en', 'validators']);

    $services->set(TwigRendererEngine::class)
        ->args([['%app.forms.default_theme%'], service(Environment::class)]);

    $services->set(FormRenderer::class)
        ->arg('$engine', service(TwigRendererEngine::class))
        ->arg('$csrfTokenManager', service(CsrfTokenManager::class));

    $services->set(CsrfExtension::class)
        ->arg('$tokenManager', service(CsrfTokenManager::class))
        ->public();

    $services->set(TranslationExtension::class)
        ->arg('$translator', service(Translator::class));

    $services->set(FormExtension::class)
        ->arg('$translator', service(Translator::class));

    $services->set(HttpFoundationExtension::class);

    $services->set(ValidatorExtension::class)
        ->arg('$validator', service(Validation::class));

    $services->set(FormFactoryBuilder::class)
        ->factory([Forms::class, 'createFormFactoryBuilder'])
        ->call('addExtension', [service(HttpFoundationExtension::class)])
        ->call('addExtension', [service(CsrfExtension::class)])
        ->call('addExtension', [service(ValidatorExtension::class)]);
};
