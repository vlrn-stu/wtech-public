<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cart;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryItem;
use App\Models\Item;
use App\Models\Stock;
use App\Models\ItemParameter;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('asdfghjkl'),
            'is_admin' => true,
        ]);

        Cart::create([
            'user_id' => 1,
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'a@a.com',
            'password' => Hash::make('asdfghjkl'),
            'is_admin' => false,
        ]);

        Cart::create([
            'user_id' => 2,
        ]);

        $items = [
            [
                'name' => 'Pistola Glock 17',
                'description' => 'Semi-automatická pištoľ Glock 17.',
                'price' => 250.00,
                'quantity' => 5,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/1.png',
                    'uploads/2.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Pištoľ'],
                    ['sub_category' => 'Munícia', 'value' => '9mm'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Semi-automatický'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '17'],
                ],
            ],
            [
                'name' => 'Revolver Smith & Wesson 686',
                'description' => 'Revolver Smith & Wesson 686 s dĺžkou hlavne 4 palce.',
                'price' => 300.00,
                'quantity' => 10,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/3.png',
                    'uploads/4.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Revolver'],
                    ['sub_category' => 'Munícia', 'value' => '.357 Magnum'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Dvojakčný'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '6'],
                ],
            ],
            [
                'name' => 'Brokovnica Remington 870',
                'description' => 'Pumpovacia brokovnica Remington 870.',
                'price' => 450.00,
                'quantity' => 7,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/5.png',
                    'uploads/6.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Brokovnica'],
                    ['sub_category' => 'Munícia', 'value' => '12 brokov'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Pumpovací'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '5'],
                ],
            ],
            [
                'name' => 'Puška CZ 527',
                'description' => 'Zameriavačka CZ 527 v kalibri .223 Remington.',
                'price' => 900.00,
                'quantity' => 3,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/7.png',
                    'uploads/8.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Zameriavačka'],
                    ['sub_category' => 'Munícia', 'value' => '.223 Remington'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Opakovací'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '5'],
                ],
            ],
            [
                'name' => 'Karabína Ruger Mini-14',
                'description' => 'Karabína Ruger Mini-14 v kalibri 5.56x45mm NATO.',
                'price' => 1200.00,
                'quantity' => 2,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/9.png',
                    'uploads/10.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Karabína'],
                    ['sub_category' => 'Munícia', 'value' => '5.56x45mm NATO'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Semi-automatický'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '20'],
                ],
            ],
            [
                'name' => 'Subkompaktná puška HK MP5',
                'description' => 'Subkompaktná puška Heckler & Koch MP5 v kalibri 9mm.',
                'price' => 1500.00,
                'quantity' => 4,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/11.png',
                    'uploads/12.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Subkompaktná puška'],
                    ['sub_category' => 'Munícia', 'value' => '9mm'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Semi-automatický / Automatický'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '30'],
                ],
            ],
            [
                'name' => 'Sniperka Sako TRG-22',
                'description' => 'Sniperka Sako TRG-22 v kalibri .308 Winchester.',
                'price' => 2500.00,
                'quantity' => 1,
                'category' => 'Zbrane',
                'images' => [
                    'uploads/13.png',
                    'uploads/14.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Sniperka'],
                    ['sub_category' => 'Munícia', 'value' => '.308 Winchester'],
                    ['sub_category' => 'Spôsob streľby', 'value' => 'Opakovací'],
                    ['sub_category' => 'Kapacita zásobníka', 'value' => '10'],
                ],
            ],
            [
                'name' => '9mm Luger',
                'description' => '9mm náboje pre pištole a subkompaktné pušky.',
                'price' => 15.00,
                'quantity' => 100,
                'category' => 'Munícia',
                'images' => [
                    'uploads/15.png',
                    'uploads/16.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Veľkosť', 'value' => '9mm'],
                ],
            ],
            [
                'name' => '5.56x45mm NATO',
                'description' => '5.56x45mm NATO náboje pre karabíny a útočné pušky.',
                'price' => 20.00,
                'quantity' => 80,
                'category' => 'Munícia',
                'images' => [
                    'uploads/17.png',
                    'uploads/18.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Veľkosť', 'value' => '5.56x45mm'],
                ],
            ],
            [
                'name' => '.357 Magnum',
                'description' => '.357 Magnum náboje pre revolver.',
                'price' => 25.00,
                'quantity' => 60,
                'category' => 'Munícia',
                'images' => [
                    'uploads/19.png',
                    'uploads/20.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Veľkosť', 'value' => '.357 Magnum'],
                ],
            ],
            [
                'name' => '12 brokov',
                'description' => '12 brokové náboje pre brokovnice.',
                'price' => 10.00,
                'quantity' => 50,
                'category' => 'Munícia',
                'images' => [
                    'uploads/21.png',
                    'uploads/22.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Veľkosť', 'value' => '12 brokov'],
                ],
            ],
            [
                'name' => 'Tričko s krátkym rukávom',
                'description' => 'Pohodlné a štýlové tričko s krátkym rukávom.',
                'price' => 10.00,
                'quantity' => 50,
                'category' => 'Oblečenie',
                'images' => [
                    'uploads/23.png',
                    'uploads/24.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Tričko'],
                ],
            ],
            [
                'name' => 'Vetrovka',
                'description' => 'Módna a teplá vetrovka pre chladnejšie počasie.',
                'price' => 60.00,
                'quantity' => 30,
                'category' => 'Oblečenie',
                'images' => [
                    'uploads/25.png',
                    'uploads/26.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Vetrovka'],
                ],
            ],
            [
                'name' => 'Mikina s kapucňou',
                'description' => 'Pohodlná a módna mikina s kapucňou.',
                'price' => 40.00,
                'quantity' => 40,
                'category' => 'Oblečenie',
                'images' => [
                    'uploads/27.png',
                    'uploads/28.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Mikina'],
                ],
            ],
            [
                'name' => 'Dlhý rukáv',
                'description' => 'Pohodlné a štýlové tričko s dlhým rukávom.',
                'price' => 20.00,
                'quantity' => 35,
                'category' => 'Oblečenie',
                'images' => [
                    'uploads/29.png',
                    'uploads/30.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Tričko'],
                ],
            ],
            [
                'name' => 'Kožená bunda',
                'description' => 'Elegantná a teplá kožená bunda.',
                'price' => 120.00,
                'quantity' => 25,
                'category' => 'Oblečenie',
                'images' => [
                    'uploads/31.png',
                    'uploads/32.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Bunda'],
                ],
            ],
            [
                'name' => 'Svetr',
                'description' => 'Teplý a pohodlný svetr vhodný na chladnejšie dni.',
                'price' => 30.00,
                'quantity' => 20,
                'category' => 'Oblečenie',
                'images' => [
                    'uploads/33.png',
                    'uploads/34.png',
                ],
                'sub_cat_items' => [
                    ['sub_category' => 'Typ', 'value' => 'Svetr'],
                ],
            ],
        ];

        foreach ($items as $itemData) {
            $category = Category::firstOrCreate(['name' => $itemData['category'], 'has_parameters' => true]);

            $subCategoryItemIds = [];
            foreach ($itemData['sub_cat_items'] as $subCatItemData) {
                $subCategory = SubCategory::firstOrCreate(['name' => $subCatItemData['sub_category'], 'category_id' => $category->id]);
                $subCategoryItem = SubCategoryItem::firstOrCreate(['value' => $subCatItemData['value'], 'sub_category_id' => $subCategory->id]);
                $subCategoryItemIds[] = $subCategoryItem->id;
            }

            $item = new Item();
            $item->name = $itemData['name'];
            $item->description = $itemData['description'];
            $item->price = $itemData['price'];
            $item->category_id = $category->id;
            $item->save();

            $item->stock()->create([
                'quantity' => $itemData['quantity']
            ]);

            foreach ($itemData['images'] as $url) {
                $image = new Image();
                $image->url = $url;
                $image->item_id = $item->id;
                $image->save();
            }

            foreach ($subCategoryItemIds as $id) {
                $itemParameter = new ItemParameter();
                $itemParameter->item_id = $item->id;
                $itemParameter->sub_category_item_id = $id;
                $itemParameter->save();
            }
        }

    }
}
