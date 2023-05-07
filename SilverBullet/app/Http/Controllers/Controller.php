<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    // Add index route
    public function index()
    {
        return view('welcome');
    }
    // Add faq route
    public function faq()
    {
        return view('faq');
    }

    public function contact()
    {
        return view('contact');
    }
}
