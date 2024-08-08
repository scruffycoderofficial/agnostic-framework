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

use CoolStuff\App\Form\Journal\EntryFormType;
use CoolStuff\Component\Controller\AbstractController;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;

/**
 * Class JournalsController.
 *
 * @package CoolStuff\App\Controller
 */
final class JournalsController extends AbstractController
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function createJournalAction(): string
    {
        $defaults = [
            'date_created' => new \DateTime('yesterday'),
        ];

        $form = $this->createForm(EntryFormType::class, $defaults, [
            'products' => $this->productRepository->all(),
        ]);

        return $this->render('journals/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
