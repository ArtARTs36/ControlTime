<?php

namespace App\Http\Controllers;

use App\Models\ControlTime;
use Illuminate\Support\Facades\DB;

class ControlTimeController extends Controller
{
    private const COUNT_WORKERS_IN_ONE_PAGE = 10;

    public function viewListAction($page = null, $sortKey = 'id', $sortDirection = 'desc')
    {
        $workers = DB::table(ControlTime::TABLE)->orderBy($sortKey, $sortDirection)
            ->paginate(self::COUNT_WORKERS_IN_ONE_PAGE, ['*'], 'page_workers', $page);

        return $workers;
    }
}

