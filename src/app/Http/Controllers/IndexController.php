<?php

namespace App\Http\Controllers;

class IndexController extends AbstractController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }
}
