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

use CoolStuff\Shared\Entity\Product;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;

/**
 * Class ListProductsCommand.
 *
 * @package CoolStuff\Module\App\Console\Command\Product
 */
final class ListProductsCommand extends Command
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
        parent::__construct('app:products:list');
    }

    protected function configure()
    {
        $this->setDescription('Lists all active products within the database.')
            ->addOption(
                'minimal',
                null,
                InputOption::VALUE_OPTIONAL,
                'Shows a minimal of 3 Product information columns.',
                true
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dataset = [];
        $products = $this->productRepository->all();

        if ($input->getOption('minimal')) {
            array_map(function (Product $product) use (&$dataset) {
                array_push($dataset, [
                    $product->getId(),
                    $product->getName(),
                    $product->isActive() ? 'Yes' : 'No',
                ]);
            }, $products);

            $table = new Table($output);

            $table
                ->setHeaders(['ID', 'Name', 'Status'])
                ->setRows($dataset);
        } else {
            array_map(function (Product $product) use (&$dataset) {
                array_push($dataset, [
                    $product->getId(),
                    $product->getName(),
                    $product->getTagline(),
                    ucfirst($product->getBrand()),
                    $product->isActive() ? 'Yes' : 'No',
                ]);
            }, $products);

            $table = new Table($output);

            $table
                ->setHeaders(['ID', 'Name', 'Tagline', 'Brand', 'Status'])
                ->setRows($dataset);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
