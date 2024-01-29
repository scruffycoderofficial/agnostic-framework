<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Tests\Component\Twig\Extension;

use DateTime;
use DateInterval;
use PHPUnit\Framework\TestCase;
use D6\Invoice\Component\Twig\Extension\AppExtension;

/**
 * Class AppExtensionTest
 *
 * @see https://www.sitepoint.com/building-custom-twig-filter-tdd-way/
 */
class AppExtensionTest extends TestCase
{
    /**
     * @dataProvider tsProvider
     */
    public function test_tss_can_be_Filtered($testTS, $expect)
    {
        $extension = new AppExtension();

        self::assertEquals($extension->tssFilter($testTS), $expect);
    }

    public static function tsProvider()
    {
        return [
            [date_sub(new DateTime(), new DateInterval('PT50S')), 'Just now'],
            [date_sub(new DateTime(), new DateInterval('PT2M')), 'Minutes ago'],
            [date_sub(new DateTime(), new DateInterval('PT57M')), 'Within an hour'],
            [date_sub(new DateTime(), new DateInterval('PT13H1M')), 'A few hours ago'],
            [date_sub(new DateTime(), new DateInterval('PT21H2M')), 'Within one day'],
            [date_sub(new DateTime(), new DateInterval('P2DT2H2M')), 'Some time back'],
            [date_sub(new DateTime(), new DateInterval('P6DT2H2M')), 'Ages ago'],
            [date_sub(new DateTime(), new DateInterval('P13DT2H2M')), 'From Mars'],
        ];
    }
}
