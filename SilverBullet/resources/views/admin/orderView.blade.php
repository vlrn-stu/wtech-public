@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/order.js') }}"></script>
    <div class="container">
        <h1 class="mb-4">Order Details</h1>

        <!-- Order Items Overview -->
        <div class="card mb-4">
            <div class="card-header">Order Items</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $orderItem)
                            <tr>
                                <td>{{ $orderItem->id }}</td>
                                <td>{{ $orderItem->item->name }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>{{ $orderItem->item->price }}$</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipping Details Overview -->
        <div class="card mb-4">
            <div class="card-header">Shipping Details</div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->shipping->name }}</p>
                <p><strong>Email:</strong> {{ $order->shipping->email }}</p>
                <p><strong>Phone:</strong> {{ $order->shipping->phone }}</p>
                <p><strong>Address:</strong> {{ $order->shipping->street_name }}, {{ $order->shipping->street_number }},
                    {{ $order->shipping->city }}, {{ $order->shipping->country }}, {{ $order->shipping->post_code }}</p>
                <button onclick="shipItem('{{ $order->id }}')" type="button" class="btn btn-primary" {{ $order->shipping->shipped ? 'disabled' : '' }}>Ship Item</button>
            </div>
        </div>

        <!-- Payment Details Overview -->
        <div class="card mb-4">
            <div class="card-header">Payment Details</div>
            <div class="card-body">
                <p>Payment Type: {{ $order->payment->type }}</p>
                <p>Total Amount: {{ $order->payment->amount }}$</p>
                <button onclick="markAsPaid('{{ $order->id }}')" type="button" class="btn btn-primary" {{ $order->payment->payed ? 'disabled' : '' }}>Mark as Paid</button>
            </div>
        </div>
    </div>
@endsection
