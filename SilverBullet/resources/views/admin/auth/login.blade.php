@extends('layouts.app')

@section('content')
    <section class="container-fluid my-3">
        <div class="row justify-content-center">

            <div class="col-12">
                <h1 class="text-center">Prihlásenie</h1>
                <form method="POST" action="{{ route('login') }}" class="form shadow rounded-5 mt-5 bg-gray">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="fs-5 col-md-2 text-md-end">Email:</label>

                        <input id="email" name="email"
                            class="@error('email') is-invalid @enderror rounded-5 col-md-9 col-12 border-0 p-1 m-2" required>
                        @error('email')
                            <span class="invalid-feedback offset-md-4" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="fs-5  col-md-2 text-md-end">Heslo:</label>
                        <input type="password" id="password" name="password"
                            class="@error('password') is-invalid @enderror rounded-5 col-md-9 col-12 border-0 p-1 m-2"
                            required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-3 d-flex justify-content-center align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Zapamätať prihlásenie
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-2 offset-md-4 mb-3">
                            <button class="gb-secondary d-block w-100 rounded-5 border-0 p-2">
                                Prihlásenie
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button class="gb-secondary d-block w-100 rounded-5 border-0 p-2" type="button" onclick="window.location.href='{{ route('register') }}'">
                                Registrácia
                            </button>
                        </div>

                        <div class="col-md-4 offset-md-4  text-center ">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Zabudol si heslo?
                                </a>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
