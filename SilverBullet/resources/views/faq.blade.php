@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="text-black">Často kladené otázky</h1>
            @for ($i = 1; $i <= 8; $i++)
                <div class="accordion col-12" id="accordionExample">
                    <div class="accordion-item col-12">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne{{ $i }}" aria-expanded="true"
                                aria-controls="collapseOne{{ $i }}">
                                Ake je tvoje životné motto, alebo filozofia podla ktorej žiješ
                            </button>
                        </h2>
                        <div id="collapseOne{{ $i }}" class="accordion-collapse collapse"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>This is the first item's accordion body.</strong> It is shown by default, until the
                                collapse plugin adds the appropriate classes that we use to style each element. These
                                classes
                                control the overall appearance, as well as the showing and hiding via CSS transitions. You
                                can
                                modify any of this with custom CSS or overriding our default variables. It's also worth
                                noting
                                that just about any HTML can go within the <code>.accordion-body</code>, though the
                                transition
                                does limit overflow.
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection
