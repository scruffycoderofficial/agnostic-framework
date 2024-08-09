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

namespace CoolStuff\Shared\Repository;

use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\QueryBuilder;
use CoolStuff\Shared\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use CoolStuff\Component\Repository\Doctrine\DoctrineORMRepository;

/**
 * Class ProductRepository.
 *
 * @package CoolStuff\Shared\Repository
 */
final class ProductRepository extends DoctrineORMRepository implements ProductRepositoryInterface
{
    protected const ENTITY_CLASS = Product::class;

    protected const ENTITY_ALIAS = 'product';

    public function __construct(protected EntityManagerInterface $manager, private ?LoggerInterface $logger = null)
    {
        parent::__construct($manager, self::ENTITY_CLASS, self::ENTITY_ALIAS);
    }

    public function all(): iterable
    {
        $products = $this->query()
            ->getQuery()
            ->getResult();

        asort($products);

        return array_filter($products, function (Product $product) {
            if ($product->isActive()) {
                return $product;
            }
        });
    }

    public function isEmpty(): bool
    {
        return empty($this->all());
    }

    public function add(EntityInterface $product): void
    {
        $this->manager->persist($product);
        $this->manager->flush();

        if (! is_null($this->logger)) {
            $this->logger->info("Saved entity ID [{$product->getId()}]");
        }
    }

    public function update(EntityInterface $product): bool
    {
        $this->manager->persist($product);
    }

    public function remove(EntityInterface $product): void
    {
        $this->manager->remove($product);
        $this->manager->flush();
    }

    public function ofId(int $productId): ?Product
    {
        $product = $this->manager->find(self::ENTITY_CLASS, $productId);

        if ($product instanceof Product) {
            return $product;
        }

        return null;
    }

    public function withActiveStatus(): ProductRepositoryInterface
    {
        return $this->filter(static function (QueryBuilder $qb) {
            $qb->where('product.is_active = true');
        });
    }

    public function registeredAfter(\DateTimeInterface $date): ProductRepositoryInterface
    {
        return $this->filter(static function (QueryBuilder $qb) use ($date) {
            $qb->where('product.createdAt < :before')
                ->setParameter(':before', $date, Types::DATETIME_MUTABLE);
        });
    }

    public function registeredBefore(\DateTimeInterface $date): ProductRepositoryInterface
    {
        return $this->filter(static function (QueryBuilder $qb) use ($date) {
            $qb->where('product.createdAt > :after')
                ->setParameter(':after', $date, Types::DATETIME_MUTABLE);
        });
    }
}
