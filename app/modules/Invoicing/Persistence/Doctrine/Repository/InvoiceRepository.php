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

namespace CoolStuff\Invoicing\Persistence\Doctrine\Repository;

use CoolStuff\Invoicing\Domain\Entity\Invoice;
use CoolStuff\Invoicing\Domain\Repository\InvoiceRepository as InvoiceRepositoryInterface;

/**
 * Class InvoiceRepository.
 *
 * @package CoolStuff\Invoicing\Persistence\Doctrine\Repository
 */
final class InvoiceRepository extends AbstractDoctrineRepository implements InvoiceRepositoryInterface
{
    protected string $entityClass = Invoice::class;
}
