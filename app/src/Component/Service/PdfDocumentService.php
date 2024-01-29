<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Service;

use Dompdf\Dompdf;

class PdfDocumentService
{
    public function __construct(private Dompdf $pdfWriter)
    {
    }

    /**
     * @param $fileName
     * @param $html
     * @param array $options
     * @return string|null
     */
    public function printInvoice($fileName, $html, array $options = []): ?string
    {
        if (! isset($options['Attachment'])) {
            array_push($options, [
                'Attachment' => false,
            ]);
        }

        $this->pdfWriter->loadHtml($html);
        $this->pdfWriter->render();

        $this->pdfWriter->stream($fileName, [
            'isHtml5ParserEnabled' => true
        ]);

        return $this->pdfWriter->output();
    }
}
