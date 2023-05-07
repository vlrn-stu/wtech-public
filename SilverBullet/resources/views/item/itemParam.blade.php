@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

    <div class="content-wrapper">
        <div class="container-fluid">
            <main class="py-4 mx-auto">
                <div class="container-fluid mt-5 mb-5 p-15">
                    <section class="row d-flex justify-content-center">
                        <div class="col-10">
                            <div class="card shadow rounded-5">
                                <div class="row no-0">
                                    <article class="col-md-4 col-sm-12">
                                        <div class="card p-4 border-0 rounded-5">
                                            <div id="carouselExampleFade" class="carousel slide">
                                                <div class="carousel-inner bg-gray rounded-5">
                                                    @foreach ($item->images as $key => $image)
                                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                            <div
                                                                style="position: relative; padding-bottom: 75%; height: 0;">
                                                                <img class="card-img-top rounded-5 position-absolute h-100 w-100"
                                                                    src="../{{ $image->url }}" alt="Card image cap" />
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carouselExampleFade" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>

                                            <div class="card-body mt-4">
                                                <p class="item card-text">
                                                    <strong>Cena:</strong> {{ $item->price }}€
                                                </p>
                                                <p class="item card-text">
                                                    <strong>Počet kusov:</strong> {{ $item->stock->quantity }}
                                                </p>
                                            </div>
                                        </div>
                                    </article>
                                    <article class="col-md-8 col-sm-12">
                                        <div class="product p-4">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title text-decoration-underline fw-bold">
                                                    {{ $item->name }}
                                                </h5>
                                                <div class="col-md-4">
                                                    <button type="submit" onclick="addItem('{{ $item->id }}')"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                        class="btn btn-danger w-100 mb-3 text-uppercase px-md-4 ml-auto p-2"
                                                        {{ $item->stock->quantity == 0 ? 'disabled' : '' }}>
                                                        Pridať do košíka
                                                    </button>
                                                    <div class="input-group w-100">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                onclick="decrementNumber()">-</button>
                                                        </div>

                                                        <input type="text" class="form-control" name="number"
                                                            value="1" id="quantity">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                onclick="incrementNumber()">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                @if ($item->category->has_parameters)
                                                    @foreach ($item->category->subcategories as $subCat)
                                                        <ul class="list-of-params mt-3">
                                                            <li>
                                                                @foreach ($item->itemParameters as $itemParameter)
                                                                    @if ($subCat->name == $itemParameter->subCategoryItem->subCategory->name)
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center">
                                                                            <p class="p-left">{{ $subCat->name }}</p>
                                                                            <span
                                                                                class="span-right">{{ $itemParameter->subCategoryItem->value }}</span>
                                                                        </div>
                                                                        <hr class="item" />
                                                                    @endif
                                                                @endforeach
                                                            </li>
                                                        </ul>
                                                    @endforeach
                                                @else
                                                    <p class="item about">
                                                        {{ $item->description }}
                                                    </p>
                                                @endif

                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/item.js') }}"></script>
@endsection

<div class="modal fade mt-5" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Položka {{ $item->name }} nebola pridaný do košíku pre nedostatok kusov
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  mt-5" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Pridané</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Položka {{ $item->name }} bola pridaný do košíku
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvoriť</button>
            </div>
        </div>
    </div>
</div>
