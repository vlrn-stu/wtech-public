<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;


class WelcomeController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->limit(4)->get();
        foreach ($items as $item) {
            $image = $item->images()->first();
            $item->image_url = $image ? $image->url : '';
        }

        return view('welcome', ['items' => $items]);
    }
}
