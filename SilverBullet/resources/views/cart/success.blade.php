@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Objednávka bola prijatá</div>
                    <div class="card-body">
                        <p>
                            Ďakujeme za nákup.
                        </p>
                        <p>
                            Tvoja transakcia bola schválená
                        </p>
                        <p>
                            Údaje o objednávke boli odoslané na tvoj email.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
