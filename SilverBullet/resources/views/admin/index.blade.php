@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items">Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders">Orders</a>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane active" id="items" role="tabpanel" aria-labelledby="items-tab">
                        @include('admin.itemsList')
                    </div>
                    <div class="tab-pane" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                        @include('admin.categoriesList')
                    </div>
                    <div class="tab-pane" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        @include('admin.ordersList')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Tab functionality
            $('.nav-tabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
    @if (session('message'))
    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        });
    </script>
    <div class="modal fade mt-5" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ session('message') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

