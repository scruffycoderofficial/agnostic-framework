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

namespace CoolStuff\App\Controller;

use CoolStuff\App\Form\Product\ViewFormType;
use Symfony\Component\HttpFoundation\Request;
use CoolStuff\App\Form\Product\UpdateFormType;
use CoolStuff\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use CoolStuff\App\Service\Product\OnlineProductsSyncer;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;

/**
 * Class ProductsController.
 *
 * @package CoolStuff\App\Controller
 */
final class ProductsController extends AbstractController
{
    private const DEFAULT_BRAND = 'local';

    public function __construct(private ProductRepositoryInterface $productRepository, private OnlineProductsSyncer $productsSyncer)
    {
    }

    public function listAction(): string
    {
        if ($this->productRepository->isEmpty()) {
            $this->productsSyncer->updateBrand(self::DEFAULT_BRAND);
        }

        return $this->render('products/list.html.twig', [
            'products' => $this->productRepository->all(),
        ]);
    }

    public function viewAction(int $productId): string
    {
        $product = $this->productRepository->ofId($productId);

        $form = $this->createForm(ViewFormType::class, $product);

        return $this->render('products/view.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    public function createAction(Request $request): string
    {
        return $this->render('products/create.html.twig');
    }

    public function updateAction(Request $request, int $productId): string|RedirectResponse
    {
        $product = $this->productRepository->ofId($productId);

        $form = $this->createForm(UpdateFormType::class, $product);

        if ($request->isMethod('POST')) {
            $product->setActive($request->request->get('is_active'));
            $this->productRepository->update($product);

            return $this->urlRedirectAction($request, 'admin_products_list');
        }

        return $this->render('products/update.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }
}
