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

namespace CoolStuff\App\Console\Command\Product;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CoolStuff\App\Service\Product\OnlineProductsSyncer;

/**
 * Class CreateProductsCommand.
 *
 * @package CoolStuff\App\Console\Command
 */
final class CreateProductsCommand extends Command
{
    protected const BRAND_LISTS = ['local', 'new', 'global', 'craft'];

    public function __construct(private OnlineProductsSyncer $onlineProductsSyncer)
    {
        parent::__construct('app:products:create');
    }

    protected function configure()
    {
        $this->setDescription('Creates Products based on a given type of brand.')
            ->addArgument('brand', InputArgument::REQUIRED, 'The brand to collect products for.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $brand = $input->getArgument('brand');

        if (! in_array($brand, self::BRAND_LISTS)) {
            throw new \Exception('Unknown type of brand.');
        }

        $this->onlineProductsSyncer->updateBrand($brand);

        return Command::SUCCESS;
    }
}
