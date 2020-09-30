@extends('layout.layout-admin')

@section('pagetitle')
    Berichte &triangleright; Systemeinstellungen | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Berichte
@endsection

@section('menu')
    <li class="nav-item {{ (strpos(Request::path(), 'reports')!==false)  ? ' active ' : '' }}">
        <a class="nav-link" href="/admin/reports/"><i class="fas fa-clipboard-list"></i> Übersicht </a>
    </li>
    <li class="nav-item {{ (strpos(Request::path(), 'reports/template')!==false)  ? ' active ' : '' }}">
        <a class="nav-link" href="{{ route('report.tempate') }}"><i class="fab fa-wpforms"></i> Vorlagen </a>
    </li>
    <li class="nav-item {{ (strpos(Request::path(), 'systems')!==false)  ? ' active ' : '' }}">
        <a class="nav-link" href="#"><i class="fas fa-tools"></i> Einstellungen </a>
    </li>
@endsection

@section('breadcrumbs')
    {{--    <nav aria-label="breadcrumb">--}}
    {{--        <ol class="breadcrumb">--}}
    {{--            <li class="breadcrumb-item"><a href="/">Portal</a></li>--}}
    {{--            <li class="breadcrumb-item active" aria-current="page">Berichte</li>--}}
    {{--        </ol>--}}
    {{--    </nav>--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">Übersicht Berichte</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3">
                        </div>
                    </div>



                </form>
            </div>
        </div>

    </div>

@endsection
