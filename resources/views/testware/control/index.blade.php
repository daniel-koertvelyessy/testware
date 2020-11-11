@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Übersicht Prüfungen')}}
@endsection

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
        @if (isset($controlItem))
            <div class="row">
                <div class="col">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">{{__('Gerät')}}</th>
                            <th>{{__('Inventar-Nr')}}</th>
                            <th class="d-none d-md-table-cell">{{__('Prüfung')}}</th>
                            <th class="d-none d-md-table-cell">{{__('Fällig bis')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse (App\ControlEquipment::orderBy('qe_control_date_due')->get() as $controlItem)
                            <tr>
                                <td class="d-none d-md-table-cell">
                                    {{ $controlItem->Equipment->Produkt->prod_name_kurz }}
                                </td>
                                <td>
                                    <span class="d-md-none">{!! $controlItem->checkDueDateIcon($controlItem) !!}</span>
                                    {{ $controlItem->Equipment->eq_inventar_nr }}
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if($controlItem->Anforderung->isInComplete($controlItem->Anforderung))
                                        <a href="{{ route('anforderung.show',$controlItem->Anforderung) }}">
                                            {{ $controlItem->Anforderung->an_name_lang }}
                                        </a>
                                        {!! $controlItem->Anforderung->isInComplete($controlItem->Anforderung)['msg'] !!}
                                    @else
                                        {{ $controlItem->Anforderung->an_name_lang }}
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    {!! $controlItem->checkDueDate($controlItem) !!}
                                </td>
                                <td>
                                    <a href="{{ route('controlevent.create',['controlItem' => $controlItem]) }}" class="btn btn-sm btn-outline-primary">
                                        <span class="d-none d-md-inline">{{__('jetzt prüfen')}}</span>
                                        <span class="fas fa-stethoscope"></span>
                                    </a>
                                    @if ($controlItem->Anforderung->isInComplete($controlItem->Anforderung))
                                        <span class="d-md-none">
                                        {!! $controlItem->Anforderung->isInComplete($controlItem->Anforderung)['msg'] !!}
                                    </span>
                                    @endif

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
                    @if ($controlItem->Anforderung->isInComplete($controlItem->Anforderung) )
                        <blockquote class="d-md-none blockquote border-left border-warning pl-3"><span class="fas fa-exclamation-triangle text-warning"
                                                                                                       aria-label="Symbol für unvollständige Prüfung"
                            ></span> => Prüfung ist unvollständig. Vor dem Start der Prüfung muss diese ergänzt werden.
                        </blockquote>
                    @endif
                </div>
            </div>
        @else

            @if(App\Produkt::count()>0)
                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-md-6 border p-3">
                        <h2 class="h5 text-info">Keine Geräte gefunden!</h2>
                        <p class="lead">Erstellen Sie ein Gerät und weisen Sie es einer Verordnung/Anforderung zu.</p>

                        <a href="{{ route('equipment.maker') }}" class="btn btn-lg btn-primary">jetzt ein Gerät erstellen <i class="fas fa-angle-right ml-3"></i></a>
                    </div>

                </div>
            @else
                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-md-6 border p-3">
                        <h2 class="h5 text-info">Keine Produkte und Geräte gefunden!</h2>
                        <p>Erstellen Sie ein Gerät und weisen Sie es einer Verordnung/Anforderung zu.</p>
                        <p class="lead my-5">
                            <span>Produkt erstelln</span>
                            <span class="fas fa-angle-right"></span>
                            <span>Gerät erstellen</span>
                            <span class="fas fa-angle-right"></span>
                            <span>Verordnung / Anforderung dem Gerät zuordnen</span>
                        </p>

                        <a href="{{ route('produkt.create') }}" class="btn btn-lg btn-primary">Erstellen Sie ein neues  Produkt <i class="fas fa-angle-right ml-3"></i></a>
                    </div>

                </div>
            @endif
        @endif
    </div>

@endsection
