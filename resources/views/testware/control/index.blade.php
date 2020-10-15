@extends('layout.layout-main')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Prüfungen')}} {{__('Übersicht')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>{{__('Gerät')}}</th>
                        <th>{{__('Inventar-Nr')}}</th>
                        <th>{{__('Prüfung')}}</th>
                        <th>{{__('Fällig bis')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\ControlEquipment::orderBy('qe_control_date_due')->get() as $controlItem)
                        <tr>
                            <td>
                                {{ $controlItem->Equipment->Produkt->prod_name_kurz }}
                            </td>
                            <td>
                                {{ $controlItem->Equipment->eq_inventar_nr }}
                            </td>
                            <td>
                                {{ $controlItem->Anforderung->an_name_lang }}
                            </td>
                            <td>
                                {!! $controlItem->checkDueDate($controlItem) !!}
                            </td>
                            <td>
                                <a href="">{{__('jetzt prüfen')}}</a>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <x-notifyer>{{__('Es sind bislang keine Prüfungen angelegt')}}</x-notifyer>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
