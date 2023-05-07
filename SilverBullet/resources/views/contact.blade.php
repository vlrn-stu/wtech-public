@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <div class="container-fluid my-3">
        <div class="row justify-content-center">

            <div class="col-12">
                <h1 class="text-center mt-5">Ako ti môžeme pomôcť?</h1>
                <form id="shipping-form" class="form shadow rounded-5 mt-5 bg-gray" method="post">

                    @csrf
                    <div class="form-group">
                        <label for="email" class="fs-5">Email:</label>
                        <input type="email" id="email" name="email" class="rounded-5" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="fs-5">Správa:</label>
                        <textarea type="text" id="name" name="name" rows="10" class="rounded-5" required></textarea>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="" class="btn bg-light border border-1 border-dark">Poslať</a>
                    </div>



                </form>
            </div>
        </div>
        <i class="bi bi-hand-thumbs-down"></i>
    </div>
@endsection
