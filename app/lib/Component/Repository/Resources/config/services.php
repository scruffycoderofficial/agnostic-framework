<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Component\Repository\Doctrine\DoctrineORMRepository;

/* @var ContainerBuilder $container */
$container->register(DoctrineORMRepository::class)
    ->isAbstract();
