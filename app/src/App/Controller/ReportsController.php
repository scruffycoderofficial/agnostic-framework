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

use Twig\Environment;
use Psr\Log\LoggerInterface;
use D6\Invoice\App\Auth\AuthService;
use D6\Invoice\App\Service\InvoiceService;
use D6\Invoice\App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\HttpFoundation\Response;
use D6\Invoice\Component\Service\PdfDocumentService;

/**
 * Class ReportsController
 */
class ReportsController
{
    const ADMIN_EMAIL = 'luyandasiko@gmail.com';

    public function __construct(
        private AuthService $authService,
        private InvoiceService $invoiceService,
        private Environment $twig,
        private FormFactoryBuilder $forms,
        private PdfDocumentService $pdfDocumentService,
        private UserRepository $userRepository,
        private ?LoggerInterface $log = null
    ) {
    }

    public function showAction(Request $request): string
    {
        if (! $request->query->has('user_email')) {
            $userEmail = self::ADMIN_EMAIL;
        }

        $user = $this->userRepository->ofEmail($userEmail);

        $invoices = $this->invoiceService->getUserReports($user->getEmail());

        return $this->twig->render('reports/list.html.twig', [
            'invoices' => $invoices,
            'user' => $user,
        ]);
    }

    public function updateAction(Request $request): string
    {
        return $this->twig->render('reports/update.html.twig');
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
            $this->pdfDocumentService->printInvoice($fileName, $htmlReport, ),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
