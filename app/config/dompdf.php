<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Dompdf\Dompdf;
use D6\Invoice\Component\Service\PdfDocumentService;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(Dompdf::class)
        ->call('setPaper', ['%app.pdf_size%', '%app.pdf_orientation%']);

    $services->set(PdfDocumentService::class)
        ->arg('$pdfWriter', service(Dompdf::class));
};
