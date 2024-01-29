<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Repository;

use Money\Money;
use Carbon\Carbon;
use Money\Currency;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class DbalRepository
 */
abstract class DbalRepository implements Repository
{
    protected QueryBuilder $queryBuilder;

    public function __construct(protected Connection $connection)
    {
        $this->queryBuilder = $connection->createQueryBuilder();
    }

    /**
     * @param $date
     * @return Carbon
     */
    public function dateParser($date): Carbon
    {
        return Carbon::parse($date);
    }

    /**
     * @var string
     */
    protected string $currency = 'ZAR';

    protected function makeMoney($value, $currency = ''): Money
    {
        if (empty($currency)) {
            $currency = $this->currency;
        }

        return new Money($value, new Currency($currency));
    }

    /**
     * @return string
     */
    protected function getMoneyLocale(): string
    {
        return $this->currency;
    }
}
