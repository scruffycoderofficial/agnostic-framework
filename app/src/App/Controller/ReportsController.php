<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\App\Controller;

use Twig\Environment;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use CoolStuff\App\Form\Invoice\CreateFormType;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\HttpFoundation\Response;
use CoolStuff\Shared\Repository\UserRepository;
use CoolStuff\Shared\Service\Invoice\InvoiceService;
use CoolStuff\Component\Service\DocumentWriter\PdfDocumentWriter;

/**
 * Class ReportsController.
 *
 * @package CoolStuff\App\Controller
 */
class ReportsController
{
    const ADMIN_EMAIL = 'luyandasiko@gmail.com';

    public function __construct(
        private InvoiceService $invoiceService,
        private Environment $twig,
        private FormFactoryBuilder $forms,
        private PdfDocumentWriter $pdfDocumentService,
        private UserRepository $userRepository,
        private EntityManager $entityManager,
        private ?LoggerInterface $log = null
    ) {
    }

    public function showAction(Request $request): string
    {
        $userEmail = 'luyandasiko@gmail.com';

        if (! $userEmail === $request->query->has('user_email')) {
            $userEmail = self::ADMIN_EMAIL;
        }

        $user = $this->userRepository->ofEmail($userEmail);

        $invoices = $this->invoiceService->getUserReports($user->getEmail());

        return $this->twig->render('reports/list.html.twig', [
            'invoices' => $invoices,
            'user' => $user,
        ]);
    }

    public function createAction(Request $request): string
    {
        $invoiceForm = $this->forms
            ->getFormFactory()
            ->create(CreateFormType::class);

        return $this->twig->render('reports/create.html.twig', [
            'form' => $invoiceForm->createView(),
        ]);
    }

    public function invoiceAction(int $userId, int $orderId): Response
    {
        $user = $this->userRepository->ofId($userId);
        $order = $this->invoiceService->getUserReport($userId, $orderId);
        $orderItems = $this->invoiceService->getInvoiceOrderItems($orderId);

        $htmlReport = $this->twig->render('reports/print.html.twig', [
            'orderItems' => $orderItems,
            'order' => $order,
            'user' => $user,
        ]);

        $fileName = sprintf('invoice-%s-%d.pdf', $order->getDateReceived()->getTimestamp(), $order->getId());

        return new Response(
            $this->pdfDocumentService->writeDocument($fileName, $htmlReport),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
