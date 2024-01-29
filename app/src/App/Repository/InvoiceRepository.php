<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Repository;

use Money\Money;
use Carbon\Carbon;
use Money\Currency;
use Doctrine\DBAL\Exception;
use D6\Invoice\App\Model\Order;
use D6\Invoice\App\Model\OrderItem;
use D6\Invoice\Component\Repository\DbalRepository;

class InvoiceRepository extends DbalRepository implements InvoiceRepositoryInterface
{
    public function getAll(int $userId): array
    {
        $result = $this->queryBuilder
            ->select('*')
            ->from('orders')
            ->where('user_id = ?')
            ->setParameter(0, $userId)
            ->fetchAllAssociative();

        $invoices = [];
        array_map(function ($entry) use (&$invoices) {
            array_push($invoices, new Order(
                $entry['id'],
                $entry['user_id'],
                Carbon::parse($entry['date_received']),
                $entry['receiver_name'],
                $entry['receive_address'],
                $this->makeMoney($entry['total_before_tax']),
                $this->makeMoney($entry['total_tax']),
                $entry['tax_per'],
                $this->makeMoney($entry['total_after_tax']),
                $this->makeMoney($entry['amount_paid']),
                $this->makeMoney($entry['total_amount_due']),
                $entry['note'],
            ));
        }, $result);

        return $invoices;
    }

    /**
     * @param $userId
     * @param $orderId
     * @return Order
     * @throws Exception
     */
    public function prepareInvoice($userId, $orderId): Order
    {
        $result = $this->queryBuilder
            ->select('*')
            ->from('orders')
            ->where('id = :id')
            ->setParameter('id', $orderId);

        $result = $result->execute()->fetchAll();

        return new Order(
            $result[0]['id'],
            $result[0]['user_id'],
            Carbon::parse($result[0]['date_received']),
            $result[0]['receiver_name'],
            $result[0]['receive_address'],
            $this->makeMoney($result[0]['total_before_tax']),
            $this->makeMoney($result[0]['total_tax']),
            $result[0]['tax_per'],
            $this->makeMoney($result[0]['total_after_tax']),
            $this->makeMoney($result[0]['amount_paid']),
            $this->makeMoney($result[0]['total_amount_due']),
            $result[0]['note'],
        );
    }

    public function prepareOrderItems($orderId): array
    {
        $result = $this->queryBuilder
            ->select('*')
            ->from('order_items')
            ->where('order_id = ?')
            ->setParameter(0, $orderId)
            ->fetchAllAssociative();

        $orderItems = [];

        array_map(function ($entry) use (&$orderItems) {
            array_push($orderItems, new OrderItem(
                $entry['id'],
                $entry['order_id'],
                $entry['item_code'],
                $entry['item_name'],
                $entry['order_item_quantity'],
                $this->makeMoney($entry['order_item_price']),
                $this->makeMoney($entry['order_item_final_amount'])
            ));
        }, $result);

        return $orderItems;
    }
}
