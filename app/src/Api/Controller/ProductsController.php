<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Api\Controller;

use Psr\Log\LoggerInterface;
use CoolStuff\Shared\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;

/**
 * Class ProductsController.
 *
 * @package CoolStuff\App\Controller
 */
class ProductsController
{
    public function __construct(private ProductRepositoryInterface $productRepository, private LoggerInterface $logger)
    {
    }

    public function listAction(): bool|string
    {
        $results = [];

        foreach ($this->productRepository->all() as $product) {
            array_push($results, [
                'name' => $product->getName(),
                'tagline' => $product->getTagline(),
                'description' => $product->getDescription(),
                'is_active' => $product->isIsActive(),
                'category' => $product->getBrand(),
            ]);
        }

        return new JsonResponse($results);
    }

    public function updateStatusAction(Request $request): JsonResponse
    {
        $data = [
            'message' => 'Could not update Product status successfully!',
        ];

        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            $this->productRepository->add((new Product())->setActive($request->get('is_active')));
            array_push($data, ['message' => 'Update Product status successfully!']);
        }

        return new JsonResponse($data);
    }
}
