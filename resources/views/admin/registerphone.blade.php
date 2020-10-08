@extends('layout.layout-portal')

@section('pagetitle')
    Smartphone aktivieren &triangleright; Portal @ bitpack.io GmbH
@endsection

@section('navigation')
    @include('menus._menuPortal')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Phono</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <p>Jetzt <a href="{{ route('makePDF',['standortliste',__('Standortbericht')]) }}" download="">aktivieren</a>!</p>
            </div>
        </div>
    </div>

@endsection
