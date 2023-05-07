@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/search.css') }}">

<section class="row d-flex justify-content-center">
    <div class="col-md-11">
        <section class="row d-flex align-items-start">

            {{-- filter --}}
            <aside class="col-md-2 border pt-3 pb-3 bg-gray rounded-5 mb-3 col-10 mx-auto">


                <input type="hidden" id="categories-data" value="{{ json_encode($categories->toArray()) }}">
                <div id="filter-container"></div>
            </aside>



            {{--content--}}

<section class="col-md-10 d-inline-block rounded-5">
    <div class="container" id="main-container">


        {{-- order by --}}
        <label for="order-by" class="me-2">Zoradiť podľa:</label>
        <select name="sort" id="sort" class="form-select form-select-sm mb-2">
            <option value="default" selected>-</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Ceny ↑</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Ceny ↓
            </option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Názvu ↑</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Názvu ↓
            </option>
        </select>
        <input type="hidden" name="search_query" value="{{ request('search_query') }}">
    </div>

                <input type="hidden" id="search-query" value="{{ request('search_query') }}">
                {{-- remove filter --}}
                @if (request()->has('search_query'))
                <div class="rounded-3 bg-gray d-inline-flex align-items-center px-2 mb-3">
                    <span class="m-2 ">{{ request()->input('search_query') }}</span>
                    <a href="{{ route('item.search') }}" class="btn btn-sm btn-danger p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-x" width="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                        </svg>
                        <input type="hidden" name="search_query" value="{{ request('search_query') }}">
                    </a>
                </div>
                @endif

                {{-- items --}}
                <input type="hidden" id="items-data" value="{{ json_encode($items->toArray()) }}">
                <div class="row" id="item-container"></div>

            </section>
    </div>
</section>

<script src="{{ asset('js/search.js') }}"></script>


@endsection