<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/* @var ContainerBuilder $container */

use Symfony\Component\DependencyInjection\ContainerBuilder;

$container->setParameter('app.locale', 'en');
$container->setParameter('app.debug', getenv('APP_DEBUG'));
$container->setParameter('app.env', getenv('APP_ENV'));
$container->setParameter('app.charset', 'UTF-8');
$container->setParameter('app.db.params', [
    'dbname' => getenv('DB_DATABASE'),
    'user' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'host' => getenv('DB_HOST'),
    'driver' => 'pdo_mysql',
]);

$container->setParameter('app.root_dir', realpath(__DIR__.'/..'));
$container->setParameter('app.logger.channel', 'daily');
$container->setParameter('app.logger.file_path', '%app.root_dir%/var/log/app.log');
$container->setParameter('app.online_status', getenv('APP_ONLINE') ?? false);
$container->setParameter('app.images.public_path', '%app.root_dir%/public/images/products');
$container->setParameter('app.products.scraping_path', '%app.root_dir%/var/products/brands');
$container->setParameter('app.session.handler_path', '%app.root_dir%/var/sessions');
$container->setParameter('app.session.admin_email', getenv('ADMIN_USER_EMAIL'));
$container->setParameter('app.mailing.mailer_dsn', getenv('MAILER_DSN'));

$container->setParameter('app.forms.default_theme', 'form_div_layout.html.twig');

$container->setParameter('app.views_dir', realpath('%root_dir%/../resources/views'));

$container->setParameter('app.pdf_size', 'A4');
$container->setParameter('app.pdf_orientation', 'landscape');

$container->setParameter('app.doctrine.fixtures_path', '%app.root_dir%/db/fixtures');
$container->setParameter('app.doctrine.orm.entity_paths', [
    '%app.root_dir%/src/Shared/Entity',
    '%app.root_dir%/modules/Invoicing/Domain/Entity',
]);
$container->setParameter('app.doctrine.entity_proxy_namespace', 'CoolStuff\Shared\Entity\Proxy');
$container->setParameter('app.doctrine.orm.entity_proxy_paths', '%app.root_dir%/src/Shared/Entity/Proxy');

/*
 * Products WebScraper supported brands parameters
 */
$container->setParameter('app.web_scrapers.products.brand.craft', 'craft');
$container->setParameter('app.web_scrapers.products.brand.local', 'local');
$container->setParameter('app.web_scrapers.products.brand.new', 'new');
$container->setParameter('app.web_scrapers.products.brand.global', 'global');

$container->setParameter('vendor.dir', realpath(__DIR__.'/../vendor'));
$container->setParameter('vendor.form_dir', '%vendor.dir%/symfony/form');
$container->setParameter('vendor.validator.dir', '%vendor.dir%/symfony/validator');
$container->setParameter('vendor.twig_bridge.dir', '%vendor.dir%/symfony/twig-bridge');
