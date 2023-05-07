@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <div class="container-fluid">
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
                        <div class="checkout-line"></div>
                        <div class="checkout-step">4</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Payment -->
        <section class="container-fluid my-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <form id="payment-form" class="form shadow rounded" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="payment_method">Spôsob platby:</label><br>
                            <input type="radio" id="cash_on_delivery" name="payment_method" value="1"
                                {{ $paymentMethod == 1 ? 'checked' : '' }}>
                            <label for="cash_on_delivery">Dobierka</label><br>
                            <input type="radio" id="bank_transfer" name="payment_method" value="2"
                                {{ $paymentMethod == 2 ? 'checked' : '' }}>
                            <label for="bank_transfer">Prevod</label><br>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Order navigation -->
        <section class="container-fluid my-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/cart/shipping" class="btn btn-primary">Spať</a>
                        <button type="submit" form="payment-form" class="btn btn-primary">Potvrdiť platbu</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
