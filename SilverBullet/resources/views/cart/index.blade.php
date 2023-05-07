@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

    <article>
        <div class="container-fluid">
            <!-- Checkout steps -->
            <section>
                <div class="container-fluid my-3">
                    <div class="row justify-content-center">
                        <div class="col-10  sm: col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="checkout-step active">1</div>
                                <div class="checkout-line"></div>
                                <div class="checkout-step">2</div>
                                <div class="checkout-line"></div>
                                <div class="checkout-step">3</div>
                                <div class="checkout-line"></div>
                                <div class="checkout-step">4</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cart items list -->
            <section>
                <div class="container-fluid mb-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="cart-list shadow rounded-5 bg-gray">
                                <ul class="list-group list-group-flush">
                                    <!-- Loop through cart items and display them -->
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @foreach ($cartItems as $cartItem)
                                        @php
                                            $item = $cartItem->item;
                                            $imageUrl = isset($item->images) ? $item->images->first()->url : '';
                                            $totalPrice += $item->price * $cartItem->quantity;
                                        @endphp
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-2 d-flex justify-content-center">
                                                    <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                                        class="img-fluid rounded-5">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="item-name">{{ $item->name }}</div>
                                                    <div class="item-description">{{ $item->description }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                onclick="decreaseQuantity({{ $item->id }})">-</button>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            value="{{ $cartItem->quantity }}" id="quantity{{ $item->id }}"
                                                            onchange="updateQuantity({{ $item->id }})">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                onclick="increaseQuantity({{ $item->id }})">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="item-price">{{ $item->price * $cartItem->quantity }}$</div>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="removeItem({{ $item->id }})">Odstrániť</button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <!-- If cart is empty, display empty cart message -->
                                    @if (count($cartItems) == 0)
                                        <li class="list-group-item">
                                            <div class="empty-cart-message text-center">
                                                <h4>Košík je prázdny</h4>
                                                <p>Pridaj produkty do košíka</p>
                                            </div>
                                        </li>
                                    @endif
                                    @if (count($cartItems) > 0)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-9"></div>
                                                <div class="col-md-2">
                                                    <div class="cart-total-price">Spolu: {{ $totalPrice }}$</div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Order navigation -->
            <section>
                <div class="container-fluid my-3">
                    <div class="row justify-content-center">
                        <div class="col-12 ">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/cart" class="btn btn-primary">Späť</a>
                                <a href="/cart/shipping"
                                    class="btn btn-primary{{ count($cartItems) == 0 ? ' disabled' : '' }}">Ďalej</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </article>

    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
