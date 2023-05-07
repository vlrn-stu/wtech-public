<!--<form action="{{ route('admin.categories_search') }}" method="GET">
    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control"
            placeholder="Search categories...">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </div>
</form>-->
<a href="{{ route('admin.categories_create') }}" class="btn btn-success">Add category</a>
<div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Has Parameters</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->has_parameters ? 'Yes' : 'No' }}</td>
                        <td>
                            <!--<a href="{ route('admin.categories_edit', $category->id) }}"
                                class="btn btn-primary">Edit</a>-->
                            <form action="{{ route('admin.categories_destroy', $category->id) }}"
                                method="POST" class="d-inline">
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
