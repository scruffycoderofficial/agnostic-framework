<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Twig\Extension;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

/**
 * Class AppExtension
 *
 * @see https://www.sitepoint.com/building-custom-twig-filter-tdd-way/
 */
class AppExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('tss', [$this, 'tssFilter']),
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'app_extension';
    }

    /**
     * @param \DateTime $timestamp
     * @return string
     */
    public function tssFilter(\DateTime $timestamp): string
    {
        $TSS = ['Just now', 'Minutes ago', 'Within an hour', 'A few hours ago', 'Within one day', 'Some time back', 'Ages ago', 'From Mars'];

        $i = -1;
        $compared = new \DateTime();

        $ts1 = $timestamp->getTimestamp();
        $co1 = $compared->getTimestamp();

        $diff = $ts1 - $co1;
        if ($diff < 0) {
            $i++;
        }

        if ($diff < -1 * 60) {
            $i++;
        }

        if ($diff < -10 * 60) {
            $i++;
        }
        if ($diff < -60 * 60) {
            $i++;
        }

        if ($diff < -16 * 60 * 60) {
            $i++;
        }

        if ($diff < -24 * 60 * 60) {
            $i++;
        }

        if ($diff < -3 * 24 * 60 * 60) {
            $i++;
        }

        if ($diff < -10 * 24 * 60 * 60) {
            $i++;
        }

        return $TSS[$i];
    }
}
