<?php

namespace App\Services\Document;

use PhpOffice\PhpWord\TemplateProcessor;

class DocxDocumentLoader implements DocumentLoaderInterface
{
    public static function save(string $templateAlias, array $templateData): string
    {
        $processor = new TemplateProcessor(self::getTemplatePath($templateAlias));
        $savePath = storage_path('docs/'. time(). '.docx');

        self::prepareData($processor, $templateData);

        $processor->saveAs($savePath);

        return $savePath;
    }

    public static function stream(string $templateAlias, array $templateData)
    {
        $savePath = self::save($templateAlias, $templateData);

        return response()->download($savePath)->deleteFileAfterSend();
    }

    private static function getTemplatePath(string $alias): string
    {
        return resource_path(implode(DIRECTORY_SEPARATOR, [
            'views',
            $alias. '.docx'
        ]));
    }

    /**
     * @param TemplateProcessor $processor
     * @param array $data
     */
    private static function prepareData(TemplateProcessor $processor, array $data)
    {
        if (!empty($data['variables']) && ($variables = $data['variables']) && is_array($variables)) {
            foreach ($variables as $key => $value) {
                $processor->setValue($key, $value);
            }
        }
    }
}
