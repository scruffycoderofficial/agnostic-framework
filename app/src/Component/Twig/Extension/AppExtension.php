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

/**
 * Class AppExtension
 */
class AppExtension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('tss', [$this, 'tssFilter']),
        ];
    }

    public function getName()
    {
        return 'app_extension';
    }

    public function tssFilter(\DateTime $timestamp)
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
