@extends('layout.layout-admin')

@section('pagetitle')
{{__('Bericht erstellen')}} &triangleright; {{__('Systemeinstellungen')}} | {{__('Start')}}
@endsection

@section('mainSection')
    {{__('Berichte')}}
@endsection

@section('menu')
    @include('menus._menu_report')
@endsection

@section('breadcrumbs')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Bericht erstellen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('report.store') }}"
                      method="POST"
                      id="frmEditReport"
                >
                    <input type="hidden"
                           name="id"
                           id="id"
                           value="{{ old('id') }}"
                    >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <x-textfield required
                                         max="100"
                                         label="{{ __('Titel') }}"
                                         id="label"
                                         value="{{ old('label') }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield label="{{ __('Name') }}"
                                         id="name"
                                         value="{{ old('name') }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="report_type_id"
                                           label="Bericht Typ"
                            >
                                @foreach(App\ReportType::all() as $reportType)
                                    <option value="{{ $reportType->id }}"
                                            @if($reportType->id === old('report_type_id')) selected @endif >{{ $reportType->name }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <x-textarea label="{{ __('Beschreibung') }}"
                                id="description"
                    >{{ old('description') }}</x-textarea>
                    <button class="btn btn-primary">
                        {{ __('Bericht speichern') }}
                        <i class="fas fa-download ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
