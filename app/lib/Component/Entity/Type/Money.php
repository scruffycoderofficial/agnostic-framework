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

namespace CoolStuff\Component\Entity\Type;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Exception\NotValidCurrency;
use CoolStuff\Component\Entity\Exception\NotCompatibleCurrency;

#[ORM\Embeddable()]
final class Money
{
    #[ORM\Column(name: 'amount', type: 'integer')]
    private int $amount;

    #[ORM\Column(name: 'currency', type: 'string')]
    private string $currency;

    /**
     * @throws NotValidCurrency
     */
    public function __construct(int $amount, string $currency)
    {
        if (3 !== strlen($currency) || strtoupper($currency) !== $currency) {
            throw new NotValidCurrency($currency);
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @throws NotCompatibleCurrency
     * @throws NotValidCurrency
     */
    public function add(self $money): self
    {
        $this->checkCurrency($money);

        return new self(
            $this->amount + $money->amount,
            $this->currency
        );
    }

    /**
     * @throws NotCompatibleCurrency
     * @throws NotValidCurrency
     */
    public function subtract(self $money): self
    {
        $this->checkCurrency($money);

        return new self(
            $this->amount - $money->amount,
            $this->currency
        );
    }

    /**
     * @throws NotCompatibleCurrency
     */
    public function equals(self $money): bool
    {
        $this->checkCurrency($money);

        return $this->currency === $money->currency && $this->amount === $money->amount;
    }

    public function isOfSameCurrency(self $money): bool
    {
        return $money->currency === $this->currency;
    }

    /**
     * @throws NotCompatibleCurrency
     */
    private function checkCurrency(self $money): void
    {
        if (! $this->isOfSameCurrency($money)) {
            throw new NotCompatibleCurrency($money->currency, $this->currency);
        }
    }

    public function __toString(): string
    {
        return sprintf('%.2f %s', $this->amount / 100, $this->currency);
    }
}
