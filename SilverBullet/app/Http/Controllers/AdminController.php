<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Image;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ItemParameter;
use App\Models\SubCategoryItem;
use Encore\Admin\Form\Field\Id;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $categories = Category::all();
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.index', ['items' => $items, 'categories' => $categories, 'orders' => $orders]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $items = Item::where('name', 'like', '%' . $search . '%')->with('category', 'image')->get();
        return view('admin.index', ['items' => $items]);
    }



    public function create()
    {
        $categories = Category::all();
        $subCategores = SubCategory::all();
        $subCategoryItems = SubCategoryItem::all();
        return view('admin.create', ['categories' => $categories, 'subCategores' => $subCategores, 'subCategoryItems' => $subCategoryItems]);
    }

    public function store_item(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image.*' => 'required|string',
            'category_id' => 'required|numeric',
            'sub_cat_item' => 'array'
        ]);
        $request->session()->forget('image_urls');

        $item = new Item();
        $item->name = $validatedData['name'];
        $item->description = $validatedData['description'];
        $item->price = $validatedData['price'];
        $item->category_id = $validatedData['category_id'];
        $item->save();

        $item->stock()->create([
            'quantity' => $validatedData['quantity']
        ]);

        foreach ($validatedData['image'] as $url) {

            $image = new Image();
            $image->url = $url;
            $image->item_id = $item->id;
            $image->save();
        }


        foreach ($validatedData['sub_cat_item'] as $id) {
            $itemParameter = new ItemParameter();
            $itemParameter->item_id = $item->id;
            $itemParameter->sub_category_item_id = $id;

            $itemParameter->save();
        }


        return redirect()->route('admin.index')->with('message', 'Položka bola úspešne pridaná.');
    }

    public function edit($id)
    {
        $item = Item::find($id);
        $sub_cat_item = $item->itemParameters->pluck('sub_category_item_id')->toArray();
        $categories = Category::all();
        return view('admin.edit', ['item' => $item, 'categories' => $categories, 'sub_cat_item' => $sub_cat_item]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image.*' => 'required|string',
            'category_id' => 'required|numeric',
            'sub_cat_item' => 'array'
        ]);

        $item = Item::find($id);

        // Update or create the item with the validated data
        $item->name = $validatedData['name'];
        $item->description = $validatedData['description'];
        $item->price = $validatedData['price'];
        $item->category_id = $validatedData['category_id'];
        $item->save();

        $stock = $item->stock;
        $stock->quantity = $validatedData['quantity'];
        $stock->update();

        // Update or create the images for the item
        $image_urls = $validatedData['image'];
        $item->images()->delete();
        foreach ($image_urls as $url) {
            $image = new Image();
            $image->url = $url;
            $image->item_id = $item->id;
            $item->images()->save($image);
        }

        // Update or create the item parameters
        $sub_cat_items = $validatedData['sub_cat_item'];
        $item->itemParameters()->delete();
        foreach ($sub_cat_items as $sub_cat_item) {
            $item_parameter = new ItemParameter();
            $item_parameter->sub_category_item_id = $sub_cat_item;
            $item_parameter->item_id = $item->id;
            $item_parameter->save();
        }
        $request->session()->forget('image_urls');

        return redirect()->route('admin.index')->with('message', 'Položka bola úspešne upravená.');
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        $imageUploadController = new ImageUploadController();

        foreach ($item->images as $image) {
            $imageUploadController->delete($image->url);
        }

        $item->stock()->delete();
        $item->images()->delete();
        $item->itemParameters()->delete();
        $item->cartItems()->delete();
        $item->orderItems()->delete();
        $item->stock()->delete();
        $item->delete();
        return redirect()->route('admin.index');
    }

    public function image_delete(Request $request)
    {

        $imageController = new ImageUploadController();
        $image_url = $request->input('image_url');
        $imageController->delete($image_url);


        $imageUrls = $request->session()->get('image_urls', []);


        $index = array_search($image_url, $imageUrls);
        if ($index !== false) {
            unset($imageUrls[$index]);
        }

        $request->session()->put('image_urls', $imageUrls);
        try {
            $image = Image::where('url', $image_url)->first();
            $image->delete();
        } catch (\Exception $e) {
        }
        return response()->json(['status' => 'success']);
    }

    public function categories_search(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::where('name', 'like', '%' . $search . '%')->get();
        return view('admin.index', ['categories' => $categories]);
    }


    public function categories_create()
    {
        return view('admin.categories_create');
    }

    public function categories_store(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->has_parameters = $request->has('has_parameters');
        $category->save();

        $subCategories = $request->input('subcategory');

        for ($i = 0; isset($subCategories[$i]); $i++) {
            $subCategory = new SubCategory();
            $subCategory->name = $subCategories[$i];
            $subCategory->category_id = $category->id;
            $subCategory->save();

            $subCategoryItems = $request->input('sub_category_item' . $i + 1);
            if (isset($subCategoryItems)) {
                foreach ($subCategoryItems as $item) {
                    $subCategoryItem = new SubCategoryItem();
                    $subCategoryItem->value = $item;
                    $subCategoryItem->sub_category_id = $subCategory->id;
                    $subCategoryItem->save();
                }
            }
        }

        $request->session()->forget('image_urls');

        return redirect()->route('admin.index');
    }

    /*public function categories_edit($id)
    {
    $category = Category::with('subCategories.subCategoryItems')->find($id);
    return view('admin.categories_edit', ['category' => $category, 'id' => $id]);
    }
    public function categories_update(Request $request, $id)
    {
    $category = Category::find($id);
    $category->name = $request->input('name');
    $category->has_parameters = $request->has('has_parameters');
    $category->save();
    $subCategories = $category->subCategories()->get();
    foreach ($subCategories as $subCategory) {
    $subCategory->subCategoryItems()->delete();
    }
    $category->subCategories()->delete();
    $subCategories = $request->input('subcategory');
    for ($i = 0; isset($subCategories[$i]); $i++) {
    $subCategory = new SubCategory();
    $subCategory->name = $subCategories[$i];
    $subCategory->category_id = $category->id;
    $subCategory->save();
    $subCategoryItems = $request->input('sub_category_item' . $i + 1);
    if (isset($subCategoryItems)) {
    foreach ($subCategoryItems as $item) {
    $subCategoryItem = new SubCategoryItem();
    $subCategoryItem->value = $item;
    $subCategoryItem->sub_category_id = $subCategory->id;
    $subCategoryItem->save();
    }
    }
    }
    return redirect()->route('admin.index');
    }*/

    public function categories_destroy($id)
    {

        $category = Category::find($id);
        if ($category->items->count() == 0) {
            $category->subCategories()->each(function ($subCategory) {
                $subCategory->subCategoryItems()->delete();
            });
            $category->subCategories()->delete();
            $category->delete();

            return redirect()->route('admin.index')->with('message', 'Kategoria bola odstránená');
        } else {
            return redirect()->route('admin.index')->with('message', 'Kategóriu nebolo možné odstrániť pretože existujú produkty s touto kategóriou');
        }
    }

    public function subcategories_get(Request $request)
    {
        $subCategory = SubCategory::where('category_id', $request->input('category_id'))->get();
        $subCategoryItem = SubCategoryItem::where('sub_category_id', $request->input('sub_category_id'))->get();
        return view('admin.edit', ['subCategory' => $subCategory, 'subCategoryItem' => $subCategoryItem]);
    }

    public function order_view($id)
    {
        $order = Order::find($id);

        return view('admin.orderView', ['order' => $order]);
    }
}
