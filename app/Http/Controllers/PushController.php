<?php

namespace App\Http\Controllers;

use App\Events\PushCreated;
use App\Helpers\FrontendResponse;
use App\Http\Requests\PushRequest;
use App\Models\Push;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PushController extends Controller
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return Push::paginate(10, ['*'], 'PushesList', $page);
    }

    public function store(PushRequest $request): FrontendResponse
    {
        $push = new Push();
        $push->title = $request->title;
        $push->message = $request->message;

        $push->save();

        event(new PushCreated($push));

        return new FrontendResponse(true, $push);
    }

    public function info(): array
    {
        return [
            'followLink' => env('PUSHALL_FOLLOW_LINK'),
            'pushesCount' => Push::count(),
            'lastDate' => Push::latest()->first()->created_at->__toString(),
        ];
    }
}
