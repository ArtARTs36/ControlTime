<?php

namespace App\Services\Document;

use Dompdf\Dompdf;

class PDFDocumentLoader
{
    /**
     * @param string $templateAlias
     * @param array $templateData
     */
    public static function load(string $templateAlias, array $templateData): void
    {
        $domPdf = self::createDomPdf();

        $domPdf->loadHtml(
            self::renderTemplate($templateAlias, $templateData)
        );

        $domPdf->render();

        $domPdf->stream();
    }

    public static function createDomPdf(): Dompdf
    {
        $domPdf = new Dompdf([
            'defaultFont' => 'calibri'
        ]);

        return $domPdf->setPaper('sra4');
    }

    public static function renderTemplate(string $alias, array $data): string
    {
        return view($alias, $data)
            ->render();
    }
}
