@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <!-- Checkout steps -->
    <section class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="checkout-step active">1</div>
                    <div class="checkout-line active"></div>
                    <div class="checkout-step active">2</div>
                    <div class="checkout-line active"></div>
                    <div class="checkout-step active">3</div>
                    <div class="checkout-line active"></div>
                    <div class="checkout-step active">4</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Order overview -->
    <section class="container-fluid my-3">
        <div class="row form justify-content-center">
            <div class="col-8">
                <h2>Prehľad objednávky</h2>
                @if ($shipping)
                    <div class="shipping-info">
                        <h4>Informácie o doručení</h4>
                        <p><strong>Meno:</strong> {{ $shipping->name }}</p>
                        <p><strong>Email:</strong> {{ $shipping->email }}</p>
                        <p><strong>Tel. č.:</strong> {{ $shipping->phone }}</p>
                        <p><strong>Adresa:</strong> {{ $shipping->street_name }}, {{ $shipping->street_number }},
                            {{ $shipping->city }}, {{ $shipping->country }}, {{ $shipping->post_code }}</p>
                    </div>
                @endif
                @if ($paymentMethod)
                    <div class="payment-info">
                        <h4>Informácie o platbe</h4>
                        <p><strong>Spôsob platby:</strong> {{ $paymentMethod == 1 ? 'Dobierka' : 'Prevod' }}</p>
                    </div>
                @endif
            </div>
            <div class="col-4">
                <div class="items">
                    <h4>Produkty:</h4>
                    <ul>
                        @foreach ($cartItems as $cartItem)
                            @php
                                $item = $cartItem->item;
                            @endphp
                            <li>{{ $item->name }} (Množstvo: {{ $cartItem->quantity }})</li>
                        @endforeach
                    </ul>
                    <p><strong>Spolu:</strong>{{ $totalAmount }}$</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Order navigation -->
    <section class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/cart/payment" class="btn btn-primary">Späť</a>
                    <form method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Potvrdiť objednávku</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
