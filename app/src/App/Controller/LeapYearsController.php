<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Controller;

use D6\Invoice\App\Model\LeapYear;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LeapYearsController
 */
class LeapYearsController
{
    /**
     * @param Request $request
     * @param int $year
     * @return string
     */
    public function index(Request $request, int $year): string
    {
        $leapYear = new LeapYear();

        if ($leapYear->isLeapYear($year) && $request->isMethod('GET')) {
            return 'Yep, this is a leap year! ';
        }

        return 'Nope, this is not a leap year.';
    }
}
