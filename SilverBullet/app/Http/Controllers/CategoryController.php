<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ItemParameter;
use App\Models\SubCategoryItem;

class CategoryController extends Controller
{
    public function subcategories_get($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        foreach($subcategories as $subcategory):
            $SubCategoryItems = SubCategoryItem::where('sub_category_id', $subcategory->id)->get();
            $subcategory->subcategoriyItems = $SubCategoryItems;
        endforeach;


        return response()->json(['success' => true, 'subCategories' => $subcategories]);
    }

    public function categories_get()
    {
        $categories = Category::all();
        return response()->json(['success' => true, 'categories' => $categories]);
    }

}
