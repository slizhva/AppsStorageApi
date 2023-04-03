<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Recipe;
use App\Models\Set;

class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data(Request $request):Renderable
    {
        $user = Auth::user();
        $set = Set
            ::where('id', $request->route('set_id'))
            ->where('user', $user->id)
            ->limit(1)
            ->get(['id', 'name'])
            ->toArray()[0];

        return view('pages.data', [
            'token' => $user->api_token,
            'dangerous_actions_key' => $user->dangerous_actions_key,
            'set' => $set
        ]);
    }
}
