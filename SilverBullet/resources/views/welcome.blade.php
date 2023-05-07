@extends('layouts.app')

@section('content')
    <div class="container-fluid ">
        <article class="row">
            <div id="carouselExampleIndicators" class="carousel slide col-12">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active bg-black slider-btn" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        class="bg-black slider-btn" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        class="bg-black slider-btn" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                        class="bg-black slider-btn" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner rounded-5 bg-gray shadow">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/pictures/slideBanner/slidebar1.png') }}" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/pictures/slideBanner/slidebar2.png') }}" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/pictures/slideBanner/slidebar3.png') }}" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/pictures/slideBanner/slidebar4.png') }}" class="d-block w-100"
                            alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </article>

        <!-- items -->
        {{-- item from html --}}
        <h1 class="pt-3">Najnovšie produkty</h1>
        <div class="row">
            @foreach ($items as $item)
                <article class="card col-xs-12 col-md-6 col-lg-3 mb-3 border-0">
                    <div class="bg-gray rounded-5 pb-1 shadow">
                        <div class="image-container position-relative" style="height: 200px;">
                            <a href="{{ route('item.itemParam', ['id' => $item->id]) }}">
                                <div class="img-wrapper">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }} image"
                                    class="card-img-top rounded-top-5">
                                </div>
                                <div
                                    class="overlay d-flex justify-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 border rounded-top-5">
                                    <img src="{{ asset('images/pictures/buttons/trolley-cart-white.png') }}"
                                        class="w-25" />
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>

                            <p class="card-text">
                                {{ $item->description }}</p>

                            <p class="card-text">{{ $item->price }}€</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection
