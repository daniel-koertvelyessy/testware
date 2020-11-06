@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Meldungen')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="h3">
                {{ __('Meldungen & Ereignisse') }}
            </h1>
        </div>
    </div>

</div>




@endsection

@section('scripts')
    <script>
        document.addEventListener ("keydown", function (zEvent) {

            if ( zEvent.altKey  &&  zEvent.key === "s") {  // case sensitive
                document.forms[0].submit()
            }
            if ( zEvent.altKey  &&  zEvent.key === "n") {  // case sensitive
                location.href = "{{ route('profile.create') }}"

            }
        } );


    </script>
@endsection
