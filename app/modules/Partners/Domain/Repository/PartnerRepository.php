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

namespace CoolStuff\Partners\Domain\Repository;

use CoolStuff\Partners\Domain\Entity\Partner;

/**
 * Interface OrderRepository.
 *
 * @package CoolStuff\Partners\Domain\Repository
 */
interface PartnerRepository extends Repository
{
    /**
     * @return Partner[]
     */
    public function getOnboarded(): array;

    /**
     * @return Partner[]
     */
    public function getDoormat(): array;

    /**
     * @return Partner[]
     */
    public function getSponsoring(): array;
}
