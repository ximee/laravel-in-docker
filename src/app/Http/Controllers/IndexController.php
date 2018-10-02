<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\User;

class IndexController extends AbstractController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index', [
            'users' => User::all(),
        ]);
    }
}
