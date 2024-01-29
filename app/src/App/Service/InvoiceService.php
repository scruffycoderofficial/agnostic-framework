<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Service;

use D6\Invoice\App\Model\Order;
use D6\Invoice\App\Repository\UserRepositoryInterface;
use D6\Invoice\App\Repository\InvoiceRepositoryInterface;

/**
 * Class InvoiceService
 */
class InvoiceService
{
    public function __construct(private InvoiceRepositoryInterface $invoices, private UserRepositoryInterface $users)
    {
    }

    public function getUserReports(string $userEmail): array
    {
        $user = $this->users->ofEmail($userEmail);

        return $this->invoices->getAll($user->getId());
    }

    public function getUserReport(int $userId, int $orderId): Order
    {
        return $this->invoices->prepareInvoice($userId, $orderId);
    }

    public function getInvoiceOrderItems($orderId): array
    {
        return $this->invoices->prepareOrderItems($orderId);
    }
}
