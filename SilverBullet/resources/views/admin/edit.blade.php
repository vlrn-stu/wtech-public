@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading fs-4">Upravenie položky</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.update', $item->id) }}">
                            {{ csrf_field() }}
                            <!-- Method spoofing :D -->
                            {{ method_field('PUT') }}

                            <!-- Name -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name', $item->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control" name="description" required>{{ old('description', $item->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-4 control-label">Price</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control" name="price"
                                        value="{{ old('price', $item->price) }}" required autofocus>

                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label for="quantity" class="col-md-4 control-label">Quantity</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="text" class="form-control" name="quantity"
                                        value="{{ old('quantity', $item->stock->quantity) }}" required autofocus>

                                    @if ($errors->has('quantity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Image -->

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">

                                <label for="image" class="col-md-4 control-label">Image</label>

                                <div class="col-md-6" id="image-field">
                                    @foreach ($item->images as $image)
                                        <div class="input-group my-3" id="item-field">
                                            <input type="text" name="image[]" id="image" class="form-control"
                                                value="{{ $image->url }}">
                                            <button class="btn btn-danger" type="button"
                                                id="btn_remove_sub_item">Odstrániť</button>
                                        </div>
                                    @endforeach
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                    <?php $image_urls = Session::get('image_urls') ?? []; ?>
                                    @foreach ($image_urls as $image_url)
                                        <div class="input-group my-3" id="item-field">
                                            <input type="text" name="image[]" id="image" class="form-control"
                                                value="{{ $image_url }}">
                                            <button class="btn btn-danger" type="button"
                                                id="btn_remove_sub_item">Odstrániť</button>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div id="select-wrapper" class="select-wrapper">
                                <div class="form-outline">
                                    <span class="select-arrow"></span>
                                </div>
                                <select class="select select-initialized rounded p-2 my-2" data-mdb-filter="true"
                                    name='category_id' id="category_id">

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" id="category"
                                            @if ($category->id == $item->category->id) selected @endif>{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- show subcategories --}}
                            <div id="sub_categories">
                                <?php $category = $item->category ?>
                                @foreach ($category->subcategories as $subCat)
                                    <label class="fs-4">{{ $subCat->name }}</label>
                                    <div>
                                        @foreach ($subCat->subCategoryItems as $subCatItem)
                                            <div>
                                                <input id="item1" name="sub_cat_item[]" type="checkbox"
                                                    value="{{ $subCatItem->id }}"
                                                    @if (in_array($subCatItem->id, $sub_cat_item)) checked @endif>
                                                <label class="mx-2">{{ $subCatItem->value }}</label>
                                            </div>
                                        @endforeach

                                    </div>
                                @endforeach

                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Upraviť
                                    </button>
                                    <button id="add-another-image" type="button" class="btn btn-primary">
                                        Pridať ďalší obrázok
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('admin.imageUpload')
        </div>
    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection
