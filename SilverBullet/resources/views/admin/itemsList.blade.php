<!--<form action="{{ route('admin.search') }}" method="GET">
    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search items...">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </div>
</form>-->
<a href="{{ route('admin.create') }}" class="btn btn-success">Add item</a>
<div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->stock->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $item->id) }}"
                                class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.destroy', $item->id) }}" method="POST"
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
