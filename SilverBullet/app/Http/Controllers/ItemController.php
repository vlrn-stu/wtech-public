<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SubCategoryItem;

class ItemController extends Controller
{
    // Add index route
    public function itemDesc($id)
    {
        $item = Item::find($id);
        return view('item.itemDesc', ['item' => $item]);
    }

    public function itemParam($id)
    {
        $item = Item::find($id);

        $parameters = $item->itemParameters;
        foreach ($parameters as $parameter) {
            $sub_category_item = $parameter->subCategoryItem->subCategory;

        }

        return view('item.itemParam', ['item' => $item]);
    }

    // Add search route
    public function search()
    {
        return view('item.search');
    }
}
