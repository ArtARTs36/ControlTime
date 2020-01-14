<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class RequestHelper
{
    /**
     * Проверка входящих параметров
     *
     * @param $data
     * @param $params
     * @return array
     */
    public static function checkParams($data, $params)
    {
        $newData = [];

        foreach ($params as $param) {
            if (isset($data[$param])) {
                $newData[$param] = $data[$param];

                continue;
            }

            throw new \LogicException('Не передан параметр: '. $param);
        }

        return $newData;
    }

    /**
     * Получить данные о записи из запроса
     *
     * @param Request $request
     * @param $requiredFields
     * @return array
     */
    public static function getEntryData(Request $request, $requiredFields)
    {
        $data = $request->all();
        if (!isset($data['entryData'])) {
            throw new \LogicException('Не получены данные о работнике!');
        }

        return self::checkParams($data['entryData'], $requiredFields);
    }
}
