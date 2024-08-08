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

namespace CoolStuff\Shared\Repository;

use CoolStuff\Shared\Entity\Order;
use CoolStuff\Component\Repository\Contract\ORMRepository;

/**
 * Interface InvoiceRepositoryInterface.
 *
 * @package CoolStuff\Shared\Repository
 */
interface InvoiceRepositoryInterface extends ORMRepository
{
    public function getAll(int $userId): array;

    public function prepareInvoice(int $userId, int $orderId): Order;

    public function prepareOrderItems(int $orderId): array;
}
