<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace D6\Invoice\Component\Twig\Extension;

use Locale;
use Money\Money;
use NumberFormatter;
use Twig\TwigFilter;
use Money\Currencies\ISOCurrencies;
use Twig\Extension\AbstractExtension;
use Money\Formatter\IntlMoneyFormatter;
use Money\Formatter\DecimalMoneyFormatter;

class MoneyExtension extends AbstractExtension
{
    /** @var string */
    private $locale;

    /** @var ISOCurrencies */
    private $currencies;

    public function __construct(?string $locale = null)
    {
        if ($locale === null) {
            $locale = Locale::getDefault();
        }

        $this->locale = $locale;
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('money_format', [$this, 'formatMoney']),
            new TwigFilter('money_decimal', [$this, 'formatDecimal']),
            new TwigFilter('money_amount', [$this, 'formatAmount']),
            new TwigFilter('money_currency', [$this, 'formatCurrency']),
        ];
    }

    public function formatMoney(?Money $money = null): string
    {
        if ($money === null) {
            return '';
        }

        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $this->getCurrencies());

        return $moneyFormatter->format($money);
    }

    public function formatDecimal(?Money $money = null): string
    {
        if ($money === null) {
            return '';
        }

        $moneyFormatter = new DecimalMoneyFormatter($this->getCurrencies());

        return $moneyFormatter->format($money);
    }

    public function formatAmount(?Money $money = null): string
    {
        if ($money === null) {
            return '';
        }

        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::DECIMAL);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $this->getCurrencies());

        return $moneyFormatter->format($money);
    }

    public function formatCurrency(?Money $money = null): string
    {
        if ($money === null) {
            return '';
        }

        return $money->getCurrency()->getCode();
    }

    private function getCurrencies(): ISOCurrencies
    {
        if (! $this->currencies) {
            $this->currencies = new ISOCurrencies();
        }

        return $this->currencies;
    }
}
