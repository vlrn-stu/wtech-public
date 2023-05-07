<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use App\Models\ItemParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function search_get(Request $request)
    {
        $query = $request->input('search_query');

        if (!empty($query)) {
            $items = Item::query()
                ->where('name', 'ilike', '%' . $query . '%')
                ->orWhereHas('category', function ($categoryQuery) use ($query) {
                    $categoryQuery->where('name', $query);
                })
                ->get();
        } else {

            $items = Item::all();
        }


        $itemIds = $items->pluck('id')->all();



        $categories = Category::whereHas('subcategories.subCategoryItems.itemParameters', function ($query) use ($itemIds) {
            $query->whereIn('item_id', $itemIds);
        })
            ->with([
                'subcategories' => function ($query) use ($itemIds) {
                    $query->whereHas('subCategoryItems.itemParameters', function ($query) use ($itemIds) {
                        $query->whereIn('item_id', $itemIds);
                    })->with(['subCategoryItems' => function ($query) use ($itemIds) {
                        $query->whereHas('itemParameters', function ($query) use ($itemIds) {
                            $query->whereIn('item_id', $itemIds);
                        });
                    }]);
                }
            ])
            ->get();

        foreach ($items as $item) {
            $image = $item->images()->first();
            $item->image_url = $image ? $image->url : '';
        }

        return view('item.search', ['categories' => $categories, 'items' => $items]);
    }

    public function search_post(Request $request)
    {
        $checkedValues = $request->input('checkedValues');
        $query = $request->input('search_query');
        $sort = $request->input('sort');

        $items = Item::query();

        if (!empty($checkedValues)) {
            $items->whereHas('itemParameters', function ($query) use ($checkedValues) {
                $query->whereIn('sub_category_item_id', $checkedValues);
            }, '=', count($checkedValues));
        }

        if (!empty($query)) {
            $items->where(function ($q) use ($query) {
                $q->where('name', 'ilike', '%' . $query . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($query) {
                        $categoryQuery->where('name', $query);
                    });
            });
        }

        if ($sort == 'price_asc') {
            $items->orderBy('price', 'asc');
        } else if ($sort == 'price_desc') {
            $items->orderBy('price', 'desc');
        } else if ($sort == 'name_asc') {
            $items->orderBy('name', 'asc');
        } else if ($sort == 'name_desc') {
            $items->orderBy('name', 'desc');
        }

        $subCategoryIds = ItemParameter::whereIn('item_id', $items->pluck('id'))->pluck('sub_category_item_id')->unique();

        $allItems = Item::all();
        $allItemsIds = $allItems->pluck('id')->all();

        $categories = Category::whereHas('subcategories.subCategoryItems.itemParameters', function ($query) use ($allItemsIds) {
            $query->whereIn('item_id', $allItemsIds);
        })
            ->with([
                'subcategories' => function ($query) use ($allItemsIds) {
                    $query->whereHas('subCategoryItems.itemParameters', function ($query) use ($allItemsIds) {
                        $query->whereIn('item_id', $allItemsIds);
                    })->with(['subCategoryItems' => function ($query) use ($allItemsIds) {
                        $query->whereHas('itemParameters', function ($query) use ($allItemsIds) {
                            $query->whereIn('item_id', $allItemsIds);
                        });
                    }]);
                }
            ])
            ->get();

        $items = $items->simplePaginate(24);
        foreach ($items as $item) {
            $image = $item->images()->first();
            $item->image_url = $image ? $image->url : '';
            $category = $item->category;
            $has_parameters = $category->has_parameters;
            $item->category_has_parameters = $has_parameters;
        }
        $items->appends([
            'search_query' => $query,
            'sort' => $sort
        ]);
        return response()->json([
            'items' => $items,
            'categories' => $categories,
            'subCategoryIds' => $subCategoryIds
        ]);
    }
}
