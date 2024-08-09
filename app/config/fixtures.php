<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\DependencyInjection\Reference;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use CoolStuff\Customers\Domain\Fixture\CustomerFixture;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Shared\Workflow\Domain\Fixture\WorkflowFixture;

/* @var ContainerBuilder $container */
$container->register(Loader::class);

$container->register(ORMPurger::class);

$container->register(ORMExecutor::class)
    ->setArgument('$em', new Reference(EntityManager::class))
    ->setArgument('$purger', new Reference(ORMPurger::class));

$container->register(CustomerFixture::class)
    ->addMethodCall('load', [new Reference(EntityManagerInterface::class)])
    ->setPublic(true);

$container->register(WorkflowFixture::class)
    ->addMethodCall('load', [new Reference(EntityManagerInterface::class)])
    ->setPublic(true);
