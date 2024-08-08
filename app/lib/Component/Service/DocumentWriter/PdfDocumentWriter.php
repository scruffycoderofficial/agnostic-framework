<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Service\DocumentWriter;

use Dompdf\Dompdf;

/**
 * Class PdfDocumentWriter.
 *
 * @package CoolStuff\Component\Service\DocumentWriter
 */
class PdfDocumentWriter
{
    public function __construct(private Dompdf $pdfWriter)
    {
    }

    public function writeDocument($fileName, $html, array $options = []): ?string
    {
        if (! isset($options['attachable'])) {
            array_push($options, [
                'Attachment' => false,
            ]);
        }

        if (isset($options['isHtml5ParserEnabled'])) {
            $this->pdfWriter->stream($fileName, [
                'isHtml5ParserEnabled' => true,
            ]);
        }

        $this->pdfWriter->loadHtml($html);
        $this->pdfWriter->render();

        return $this->pdfWriter->output();
    }
}
