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
                        <div class="checkout-line"></div>
                        <div class="checkout-step">3</div>
                        <div class="checkout-line"></div>
                        <div class="checkout-step">4</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Shipping -->
        <section class="container-fluid my-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="errors-container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <form id="shipping-form" class="form shadow rounded" method="post" action="{{ route('cart.storeShipping') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Meno:</label>
                            <input class="rounded-5" type="text" id="name" name="name" value="@isset($shipping){{ $shipping->name }}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="rounded-5" type="email" id="email" name="email" value="@isset($shipping){{ $shipping->email }}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Tel. č.:</label>
                            <input class="rounded-5" type="tel" id="phone" name="phone" value="@isset($shipping){{ $shipping->phone }}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Krajina:</label>
                            <select class="rounded-5" id="country" name="country" required>
                                <option value="">Zvoľ krajinu</option>
                                <option value="Slovakia" @isset($shipping){{ $shipping->country == 'Slovakia' ? 'selected' : '' }}@endisset>Slovensko</option>
                                <option value="Japan" @isset($shipping){{ $shipping->country == 'Japan' ? 'selected' : '' }}@endisset>Japonsko</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="city">Mesto:</label>
                                    <input class="rounded-5" type="text" id="city" name="city" value="@isset($shipping){{ $shipping->city }}@endisset" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="post_code">PSČ:</label>
                                    <input class="rounded-5" type="text" id="post_code" name="post_code" value="@isset($shipping){{ $shipping->post_code }}@endisset" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="street_name">Názov ulice:</label>
                                    <input class="rounded-5" type="text" id="street_name" name="street_name" value="@isset($shipping){{ $shipping->street_name }}@endisset" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="street_number">Číslo vchodu:</label>
                                    <input class="rounded-5" type="text" id="street_number" name="street_number" value="@isset($shipping){{ $shipping->street_number }}@endisset" required>
                                </div>
                            </div>
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
                        <a href="/cart" class="btn btn-primary">Späť</a>
                        <button type="submit" form="shipping-form" class="btn btn-primary">Potvrdiť</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
