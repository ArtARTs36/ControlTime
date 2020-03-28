<?php

namespace App\Services\Document;

class Document
{
    const TEMPLATES_FOLDER = 'document-templates';
    const TEMPLATE_TIME_REPORT = self::TEMPLATES_FOLDER . '/time_report';
    const TEMPLATE_VACATION_APPLICATION_YEAR = self::TEMPLATES_FOLDER . '/vacation_application_year';
    const TEMPLATE_VACATION_APPLICATION_YEAR_WITH_DISMISSAL = self::TEMPLATES_FOLDER . '/vacation_application_year_with_dismissal';
    const TEMPLATE_VACATION_APPLICATION_WITHOUT_SALARY = self::TEMPLATES_FOLDER . '/vacation_application_without_salary';

    const VACATION_APPLICATION_TYPES = [
        1 => self::TEMPLATE_VACATION_APPLICATION_YEAR,
        2 => self::TEMPLATE_VACATION_APPLICATION_YEAR_WITH_DISMISSAL,
        3 => self::TEMPLATE_VACATION_APPLICATION_WITHOUT_SALARY,
    ];
}
