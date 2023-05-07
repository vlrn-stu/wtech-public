# SILVER BULLET- SEMESTRÁLNY PROJEKT WTECH

## Zadanie

Vytvorte webovú aplikáciu - eshop, ktorá komplexne rieši nižšie definované prípady použitia vo vami zvolenej doméne (napr. elektro, oblečenie, obuv, nábytok). Presný rozsah a konkretizáciu prípadov použitia si dohodnete s vašim vyučujúcim.

### Autori

[vlrn-stu - Overview](https://github.com/vlrn-stu)

Máté Konkoly

[SimonValicek - Overview](https://github.com/SimonValicek)

Šimon Valíček

[VarDaviS - Overview](https://github.com/VarDaviS)

Dávid Varinský

## Fyzický dátový model

### Pôvodný model

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled.png)

### Aktuálny model

![admin_menu.png](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/admin_menu.png)

### Zmeny oproti pôvodnému návrhu

V priebehu implementácie sa zistilo, že na určenie kategórie a parametrov produktu bude treba viac ako len tabuľku kategórií. Preto boli pridané tabuľky **sub_categories** a **sub_categories_items**.

Vysvetlíme si to na nasledujúcom príklade. Ak je kategória oblečenie, potrebujeme vedieť o aký typ oblečenia sa jedná, akej veľkosti je dané oblečenie a iné. Za týmto účeľom vznikla tabuľka **sub_categories**. Ak už vieme, že v tabuľke **sub_categories** bude typ a veľkosť oblečenie, potrebujeme ešte vedieť aj konkrétny typ a konkrétnu veľkosť, napr. oblečenie typu tričko o veľkosti M. V našej databáze to je zapísané nasledovne. Kategória→Podkategória (**subcategory**)→Hodnota(**subcategory_item**), čiže Oblečenie→Typ→Tričko, alebo Oblečenie→Veľkosť→M. Avšak aby sme mohli toto tričko z nášho príkladu zapísať pod všetky parametre, potrebujeme tabuľku **item_parameters**, ktorá slúži na párovanie týchto údajov. V tabuľke item_parameter pridelíme produkt tričko k hodnote M, k typu tričko atď.

V porovnaní s návrhom pribudla tabuľka **users**, ktorú sme nepredpokladali napriek tomu, že je veľmi intuitívna.

Následne pribudli tabuľky vygenerované automaticky, ktoré sme v návrhu taktiež nepredpokladali, ale ktoré sa ukázali ako podstatné. 

Z pôvodného návrhu bola odstránená tabuľka **payments**, nakoľko to v rámci projektu neriešime. Ak by však išlo o reálny e-shop, považujeme za nutné pridanie tejto tabuľky

## Návrhové rozhodnutia

### Všeobecný popis

V aplikácii bolo použitých niekoľko externých knižníc. Na ich špecifikáciu slúži nasledujúci zoznam, obsahujúci knižnice tak, ako sú uvedené v ****************************composer.json**************************** súbore aplikácie, spolu s verziami, ktoré boli použité a ich stručným popisom.

1. **"php": "^8.1"** - Špecifikácia verzie PHP projektu.
2. **"encore/laravel-admin": "^1.8"** - Zabezpečuje admin rozhranie aplikácie.
3. **"guzzlehttp/guzzle": "^7.2"** - PHP HTTP klient zabezpečujúci HTTP volania Laravel aplikácie.
4. **"laravel/framework": "^10.0"** - Základný balík Laravel frameworku na zabezpečenie jednoduchej funkcionality pre vývoj webových aplikácií.
5. **"laravel/sanctum": "^3.2"** - Balík Laravel frameworku zabezpečujúci autentifikáciu za pomoci tokenov.
6. **"laravel/tinker": "^2.8"** - Balík Laravel frameworku zabezpečujúci interakciu kódu a dát aplikácie.
7. **"laravel/ui": "^4.2"** - Balík Laravel frameworku, ktorý slúži na vytváranie frond-end komponentov aplikácie (napr. pre autentifikáciu).

Zoznam ďalších externých knižníc s príslušnou verziou a popisom, tak ako sú uvedené v **package.json**.

1. **"@popperjs/core": "^2.11.6" -** Externá knižnica slúžiaca na manipuláciu s front-end prvkami webových aplikácií, používaná v súvislosti s inými front-end frameworkmi ako v našom prípade bootstrap.
2. **"axios": "^1.1.2"** - Externá knižnica zabezpečujúca zjednodušenie manipulácie HTTP volaní a následné spracovanie odpovedí daných volaní.
3. **"bootstrap": "^5.3.0-alpha1"** -  CSS front-end framework, slúžiaci na zjednodušenie tvorby štylizovaných elementov. V našom prípade použitý najmä z dôvodu zabezpečenia responzívneho dizajnu.
4. **"laravel-mix": "^6.0.49"** - Externá knižnica na zjednodušenie manipulácie a kompilácie pripojených JavaScript súborov, CSS súborov a obrázkov. 
5. **"laravel-vite-plugin": "^0.7.2"** - Plugin slúžiaci na integráciu Vite v prostredí Laravelu, pre lepšiu a efektívnejšiu tvorbu webových aplikácií. 
6. **"sass": "^1.56.1"** - CSS preprocesor, rozširujúci tradičné CSS, slúžiaci na zjednodušenie písania jednotlivých štýlov a následnú manipuláciu s nimi. 
7. **"vite": "^4.0.0"** - Zabezpečuje rýchlejší a efektívnejší vývoj webových aplikácií. 

### Programovacie prostredie

Pre prácu na danom projekte využíval náš tým programovacie prostredie **VisualStudio Code**, tak, ako bolo uvedené v odporúčaniach.

## Implementácia vybraných prípadov použitia

### **********************Prihlásenie**********************

Pre prihlásenie užívateľov aplikácia využíva modul Breeze, podporovaný Laravelom. Po vytvorení nového Laravel projektu sa pomocou Composeru inštaluje balík Breeze nasledovne.

```jsx
composer require laravel/breeze --dev
```

Po nainštalovaní balíka sa spustí nasledujúci príkaz, ktorý vygeneruje všetky potrebné súbory.

```jsx
php artisan breeze:install
```

Následne bolo pomocou CSS upravené užívateľské rozhranie pre prihlasovanie.

### ********************************Zmena množstva pre daný produkt********************************

V súbore ********************************index.blade.php******************************** ku ktorej prislúcha stránka “****************/admin****************” je implementovaný list produktov nasledovne, odkazom na súbor ************************************itemList.blade.php************************************

```php
<div class="tab-pane active" id="items" role="tabpanel" aria-labelledby="items-tab">
	  @include('admin.itemsList')
</div>
```

Vo vnútri tohto vnoreného súboru sa renderujú všetky produkty pre adminitrátorské rozhranie, ktoré slúži na ich úpravu. Pre každý produkt je vygenerované tlačidlo “Edit” zadefinované v súbore ************************************itemList.blade.php************************************ ako odkaz na stránku “******************************/admin/edit/${id_produktu}******************************” v podobe get requestu, reprezentovanú súborom ****************************edit.blade.php**************************** 

```php
<a href="{{ route('admin.edit', $item->id) }}"class="btn btn-primary">Edit</a>
```

Po kliknutí na tento odkaz sa v súbore **************************************AdminController.php**************************************  zavolá funkcia ****edit****

```php
public function edit($id)
    {
        $item = Item::find($id);
        $sub_cat_item = $item->itemParameters->pluck('sub_category_item_id')->toArray();
        $categories = Category::all();
        return view('admin.edit', ['item' => $item, 'categories' => $categories, 'sub_cat_item' => $sub_cat_item]);
    }
```

Tá nájde v databáze produkt s prislúchajúcim $id a vracia náhľad novej stránky “******************************/admin/edit/${id_produktu}******************************” reprezentujúcu súborom ****************************edit.blade.php.**************************** Okrem toho posiela na novú stránku nasledujúce informácie: 

- id produktu
- kategórie, do ktorých daný produkt patrí
- parametre, ktoré produkt obsahuje

Následne sa na novej stránke upraví kolónka “Quantity” zadefinovaná v ******************************edit.blade.php****************************** nasledovne

```php
<!-- Quantity -->
<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
    <label for="quantity" class="col-md-4 control-label">Quantity</label>

    <div class="col-md-6">
        <input id="quantity" type="text" class="form-control" name="quantity"
            value="{{ old('quantity', $item->stock->quantity) }}" required autofocus>

        @if ($errors->has('quantity'))
            <span class="help-block">
                <strong>{{ $errors->first('quantity') }}</strong>
            </span>
        @endif
    </div>
</div>
```

Po vyplnení kolónky - číselná informácia o novom počte produktov, sa kliknutím na tlačidlo “Upraviť” zachovajú zmeny

```php
<button type="submit" class="btn btn-primary">Upraviť</button>
```

Väčšina kódu v súbore ****************************edit.blade.php**************************** je zaobalená vo <form> elemente s metódou post. Po stlačení tohto tlačidla sa zavolá spomínaná metóda post, ktorá zavolá funkciu ****update**** v súbore **AdminController.php**

```php
public function update(Request $request, $id)
    {
	      ...
				...
				...
        return redirect()->route('admin.index')->with('message', 'Položka bola úspešne upravená.');
    }
```

Funkcia obsahuje kód zabezpečujúci upravenie parametrov (kategórií, podkategórií, množstva…) produktu s príslušným $id.

Po vykonaní kódu presmerováva na pôvodnú stránku “************/admin************“ reprezentovanú súborom ******************************index.blade.php******************************. Po úspešnom presmerovaní vyskočí pop-up okno so správou o úspešnom upravení produktu.

### ************************Vyhľadávanie************************

Vyhľadávanie je implementované prostredníctvom nasledujúceho kódu, ktorý sa nachádza v súbore **********************************navbar.blade.php**********************************. Tento súbor predstavuje navigačný panel a je zahrnutý vo všetkých náhľadoch aplikácie. 

```php
<form action="{{ route('item.search') }}" method="GET" class="form-inline my-2 my-lg-0 mx-auto col-xl-4 col-sm-12 col-md-5 d-inline-flex">
		<input class="form-control mr-sm-2 rounded-5 rounded-left" type="text" name="search_query" placeholder="Vyhľadávanie" aria-label="Search">
		<button class="btn btn-outline-success my-sm-0 rounded-5" type="submit">Vyhľadaj</button>
</form>
```

Po zadaní textu do vstupného poľa a následným stlačením tlačidla “Vyhľadávanie”, prebehne plnotextové vyhľadávanie nad katalógom produktov. To je zabezpečené volaním metódy get daného <form> elementu, ktorým sa zavolá nasledujúca funkcia, zadefinovaná v súbore ****************************************SearchController.php****************************************

```
public function search_get(Request $request)
    {
        ...
				...
				...
        return view('item.search', ['categories' => $categories, 'items' => $items]);
    }
```

Výsledkom volania funkcie je náhľad novej stránky, reprezentovanej súbormi ******************search.blade.php****************** a ********************search.js********************, na ktorej je vyobrazený katalóg produktov, vyfiltrovaných na základe vyššie spomenutého plnotextového vyhľadávania. 

### ******************************************************Pridanie produktu do košíka******************************************************

Na stránke **“/item/id”** sa zvolí množstvo a následne sa stalčí tlačidlo “Pridať do košíka”. To zavolá funkciu zo súboru “item.js”, ktorá vyzerá nasledovne.

```
function addItem(itemId) {
    console.log(`updateItemQuantity called with itemId=${itemId}`);
    let quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value);

    fetch(`/cart/item/${itemId}/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                item_id : itemId,
                quantity: quantity
            })
        })
        .then(response => {
            if (response.ok) {

            } else {
                console.error('Failed to update item quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
```

Tá odošle post request na CartController, kde sa pomocou funkcie *addItem* pridá dané množstvo vybraného produktu do košíka. Celá funkcia je implementovaná nasledovne.

```php
public function addItem(Request $request)
    {
        $item_id = $request->input('item_id');
        $quantity = $request->input('quantity', 1);

        if ($quantity < 1) {
            return response()->json(['error' => 'Quantity must be greater than 0'], 400);
        }

        $item = Item::find($item_id);
        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        if ($item->stock->quantity < $quantity) {
            return response()->json(['error' => 'Not enough stock'], 400);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            $cartItem = CartItem::firstOrCreate([
                'cart_id' => $cart->id,
                'item_id' => $item->id,
            ], [
                    'quantity' => 0,
                ]);

            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItems = Session::get('cartItems', []);
            $itemKey = array_search($item_id, array_column($cartItems, 'id'));

            if ($itemKey !== false) {
                $cartItems[$itemKey]['quantity'] += $quantity;
            } else {
                $cartItem = [
                    'item_id' => $item->id,
                    'quantity' => $quantity
                ];
                array_push($cartItems, $cartItem);
            }

            Session::put('cartItems', $cartItems);
        }

        return response()->json(['success' => 'Item added to cart'], 200);
    }
```

### ****Stránkovanie****

Stránkovanie je zabezpečené pomocou metódy ***********search_get*********** v rámci súboru **SearchController.js**, kde namiesto vrátenia všetkých produktov, ktoré sú výsledkom vyhľadávania je vrátený len určitý počet z nich, ktorý sa má zobraziť na stránke. 

```php
public function search_get(Request $request)
    {
				...
				...
				...
        $items = $items->simplePaginate(24)
				...
				...
				...
        return view('item.search', ['categories' => $categories, 'items' => $items]);
    }
```

Ak je produktov viac, ako daný počet, v náhľade stránky, reprezentovanej súborom **********************************search.blade.php********************************** sa zobrazí odkaz na preklikávanie sa naprieč stranami produktov.

### ****************************************Základné filtrovanie****************************************

Filtrovanie je implementované za použitia súborov **SearchController.js**, **search.blade.php** a ******************search.js******************. Po načítaní stránky na adrese “**************/search**************”, sa zavolá get request, spracovaní na backend-e funkciou **********search_get**********

```php
public function search_get(Request $request)
    {
        ...
				...
				...
        return view('item.search', ['categories' => $categories, 'items' => $items]);
    }
```

Ak existuje filtrovanie, funkcia vracia zoznam filtrovaných produktov a všetkých kategórií, pre ktoré existuje produkt. 

Funkcia taktiež vracia náhľad stránky, reprezentovanej súborom ********************************search.blade.php********************************, ktorý zabezpečuje základnú štruktúru užívateľského rozhrania stránky. K tomuto súboru je pripojený súbor ******************search.js******************, ktorý zabezpečuje renderovanie filtra a produktov. Spôsoby filtrovania sú tri.

- Užívateľ má možnosť zadať názov produktu do vyhľadávania. Tento spôsob je podrobnejšie popísaný v kapitole vyššie.
- Užívateľ má možnosť zoradiť produkty podľa ceny a mena, či už vzostupne, alebo zostupne.
    
    To je zabezpečené nasledujúcim kódom v rámci súboru ********************************search.blade.php********************************
    

```
<section class="col-md-10 d-inline-block rounded-5">
    <div class="container" id="main-container">

        {{-- order by --}}
        <label for="order-by" class="me-2">Zoradiť podľa:</label>
        <select name="sort" id="sort" class="form-select form-select-sm mb-2">
            <option value="default" selected>-</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Ceny ↑</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Ceny ↓
            </option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Názvu ↑</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Názvu ↓
            </option>
        </select>
        <input type="hidden" name="search_query" value="{{ request('search_query') }}">
    </div>
```

Pre daný <select> element existuje v súbore ******************search.js****************** prislúchajúci event listener, repezentovaný nasledovne

```coffeescript
const selectSort = document.getElementById("sort");
selectSort.addEventListener("change", () => {
    const checkedValues = Array.from(checkboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.value);

    const sortValue = selectSort.value;
    console.log(sortValue);
    fetchFilteredAndSortedItems(checkedValues, sortValue);
});
```

- Užívateľ má možnosť filtrovať pomocou filtra, obsahujúceho zoznam kategórii, podkategórií a parametrov. Pre jednotlivé parametre sú vyrenderované <input> elementy typu “checkbox”, pričom každý z týchto elementov má vlastný event listener. Filter je obsiahnutý v ********************search.js******************** súbore a implementovaný nasledovne

```jsx
categories.forEach((category) => {
    ...
		...
    category.subcategories.forEach((subcategory) => {
        ...
				...
        subcategory.sub_category_items.forEach((subcategory) => {
            ...
						...
            const input = document.createElement("input");
            input.type = "checkbox";
            input.classList.add("custom-control-input");
            input.value = subcategory.id;
            input.name = "filter[]";
            const text = document.createTextNode(subcategory.value);
            label.appendChild(input);
            label.appendChild(text);
            checkboxDiv.appendChild(label);
            subcategorySection.appendChild(checkboxDiv);
        });
			...
    });
	...
});
```

Každý <input> element typu “checkbox” má vlastný event lister, ako sa spomína v texte vyššie.

```jsx
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

const onCheckboxChange = (event) => {
    const checkbox = event.target;

    console.log(checkbox.value);
    checkbox.removeEventListener("change", onCheckboxChange);

    const checkedCheckboxes = Array.from(checkboxes).filter(
        (checkbox) => checkbox.checked
    );
    const checkedValues = checkedCheckboxes.map((checkbox) => checkbox.value);
    checkboxes.forEach((checkbox) => {
        checkbox.disabled = false;
    });

    const sortValue = selectSort.value;
    fetchFilteredAndSortedItems(checkedValues, sortValue);
    checkbox.addEventListener("change", onCheckboxChange);
};

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", onCheckboxChange);
});
```

Všetky tri spôsoby filtrovania sú kompatibilné a “nerušia” sa navzájom. Toto komplexné filtrovanie zastrešuje funkcia ***************************fetchFilteredAndSortedItems*************************** implementovaná v rámci súboru ******************search.js.******************

```jsx
function fetchFilteredAndSortedItems(checkedValues, sortValue) {
    fetch("/search", {
        method: "POST",
        body: JSON.stringify({
            checkedValues,
            sort: sortValue,
            search_query,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        ...
        ...
        ...
}
```

Funkcia posiela request typu post na adresu “**************/search**************”, ktorým je volaná funkcia ***search_post*** v rámci súboru **SearchController.js**

```php
public function search_post(Request $request)
    {
	      ...
				...
        return response()->json([
            'items' => $items,
            'categories' => $categories,
            'subCategoryIds' => $subCategoryIds
        ]);
    }
```

Tá zabezpečuje výber produktov, kategórií a parametrov nad databázou a posiela ich naspäť funkcii *fetchFilteredAndSortedItems* v json formáte, reprezentovanej v súbore ******************search.js******************

Následne nad vrátenými údajmi prebieha renderovanie. Renderujú sa jednotlivé karty produktov a upravuje sa filter tak, aby nebolo možné zaškrtnúť checkboxy s kategóriami, pre ktoré neboli vrátené produkty. 

```jsx

function fetchFilteredAndSortedItems(checkedValues, sortValue) {
			...
			...
			.then((data) => {
            const subCategoryIds = Array.isArray(data.subCategoryIds)
                ? data.subCategoryIds
                : Object.values(data.subCategoryIds);

            console.log("sub", subCategoryIds);
            updateItems(data.items.data);

            const updatedCheckedCheckboxes = Array.from(checkboxes).filter(
                (checkbox) => checkbox.checked
            );

            const noCheckboxesChecked = updatedCheckedCheckboxes.length === 0;

            checkboxes.forEach((checkbox) => {
                if (noCheckboxesChecked) {
                    checkbox.disabled = false;
                } else if (
                    !subCategoryIds.includes(parseInt(checkbox.value)) &&
                    !checkbox.checked
                ) {
                    checkbox.disabled = true;
                }
            });
        })
```

## Snímky obrazoviek

### Navigačný panel

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%201.png)

### Katalóg produktov

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%202.png)

### Košík

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%203.png)

### Admin panel

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%204.png)

### Detail produktu

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%205.png)

### Prihlásenie

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%206.png)

### Homepage

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%207.png)

### Pridávanie kategórií

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%208.png)

### Footer

![Untitled](SILVER%20BULLET-%20SEMESTRA%CC%81LNY%20PROJEKT%20WTECH%202f896d0b2903484bb05b800ecfaa2c73/Untitled%209.png)