@extends('layouts.app')

@section('content')
    <section class="container-fluid my-3">
        <div class="row justify-content-center">

            <div class="col-12">
                <h1 class="text-center">Register</h1>
                <form method="POST" action="{{ route('register') }}" class="form shadow rounded-5 mt-5 bg-gray">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="fs-5 col-md-2 text-md-end">{{ __('Name') }}</label>

                        <input id="name" name="name"
                            class="@error('name') is-invalid @enderror rounded-5 col-md-9 col-12 border-0 p-1 m-2"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="fs-5 col-md-2 text-md-end">{{ __('Email Address') }}</label>

                        <input id="email" name="email"
                            class="@error('email') is-invalid @enderror rounded-5 col-md-9 col-12 border-0 p-1 m-2"
                            value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="fs-5  col-md-2 text-md-end">{{ __('Password') }}</label>

                        <input type="password" id="password" name="password"
                            class="@error('password') is-invalid @enderror rounded-5 col-md-9 col-12 border-0 p-1 m-2"
                            required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="fs-5 col-md-2 text-md-end">{{ __('Confirm Password') }}</label>

                        <input type="password" id="password-confirm" name="password_confirmation"
                            class="rounded-5 col-md-9 col-12 border-0 p-1 m-2" required autocomplete="new-password">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-3 d-flex justify-content-center align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-4 offset-md-4">
                            <button class=" d-block w-100 rounded-5 border-0 p-2">
                                Registrovať
                            </button>
                        </div >
                        <div class="col-md-4 offset-md-4 mt-3 text-center ">
                            <a class="btn btn-link" href="{{ route('login') }}">
                                {{ __('Already have an account?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
