<!--<form action="{{ route('admin.search') }}" method="GET">
    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search items...">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </div>
</form>-->
<div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Buyers Name</th>
                    <th>Payment Status</th>
                    <th>Shipping Status</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->shipping->name }}</td>
                        <td>{{ $order->payment->payed ? 'Paid' : 'Unpaid'}}</td>
                        <td>{{ $order->shipping->shipped ? 'Shipped' : 'Not Shipped'}}</td>
                        <td>{{ $order->payment->amount }}</td>
                        <td>
                            <a href="{{ route('admin.order_view', $order->id) }}"
                                class="btn btn-primary">View</a>
                            <form action="{{ route('admin.order_destroy', $order->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
