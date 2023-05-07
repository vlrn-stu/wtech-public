@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default ">
                    <div class="panel-heading fs-4">Vytvorenie kategórie</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.categories_store') }} ">
                            {{ csrf_field() }}

                            <!-- Name -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6 border">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>


                            <!-- Description -->
                            <div class="form-group{{ $errors->has('has_subcategories') ? ' has-error' : '' }}">
                                <label for="subcategory" class="col-md-4 control-label ">Podkategória</label>

                                <div class="col-md-6" id="subcategory-field">
                                    <div id="sub_cat_item1">
                                        <div class="input-group" id='input'>
                                            <input type="text" class="form-control " id="subcategory"
                                                name="subcategory[]"
                                                value="{{ old('subcategory') }}" required autofocus>
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon">Pridať hodnotu</button>
                                        </div>

                                        @if ($errors->has('subcategory'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('subcategory') }}</strong>
                                            </span>
                                        @endif
                                        <div class="col-md-12 " id="sub_category_item-field">

                                        </div>

                                    </div>
                                </div>


                                <div>
                                    <label>
                                        <input type="checkbox" name="has_parameters" value="has_parameters">
                                        Zobraziť parametre
                                    </label>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Pridať
                                        </button>
                                        <button id="add-another-subcategory" type="button" class="btn btn-primary">
                                            Pridať ďalšiu podkategóriu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection
