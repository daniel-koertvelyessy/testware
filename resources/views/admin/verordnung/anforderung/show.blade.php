@extends('layout.layout-admin')

@section('pagetitle','Anforderung')

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection

@section('modals')

    <div class="modal fade" id="modalAddNewAnforderungType" tabindex="-1" aria-labelledby="modalAddNewAnforderungTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Neuen Anforderungstyp anlegen')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addNewAnforderungType') }}"
                          method="post" id="frmAddNewAnforderungsType"
                    >
                        @csrf
                        <x-rtextfield id="at_label"
                                      label="Kürzel"
                        />
                        <x-textfield id="at_name"
                                     label="Name"
                        />
                        <x-textarea id="at_description"
                                    label="Beschreibung"
                        />

                        <x-btnMain>Anforderungstyp anlegen <span class="fas fa-download"></span></x-btnMain>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Anforderung')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('anforderung.update',$anforderung) }}" method="POST" id="frmEditVerordnungen" name="frmEditVerordnungen">
                    @csrf
                    @method('PUT')
                    <input type="hidden"
                           name="id"
                           value="{{ $anforderung->id }}"
                    >

                    <x-selectfield name="verordnung_id" id="verordnung_id" label="Gehört zu Verordnung">
                        @foreach (App\Verordnung::all() as $ad)
                            <option value="{{ $ad->id }}"
                                    @if ($ad->id === $anforderung->verordnung_id)
                                    selected
                                @endif
                            >{{ $ad->vo_label }}</option>
                        @endforeach
                    </x-selectfield>


                        <x-selectModalgroup id="anforderung_type_id" label="Anforderung Typ"
                                            modalid="modalAddNewAnforderungType">
                            @foreach(App\AnforderungType::all() as $anforderungType)
                                <option value="{{ $anforderungType->id }}">{{ $anforderungType->at_name }}</option>
                            @endforeach
                        </x-selectModalgroup>

                    <x-rtextfield id="updt_an_label" name="an_label" label="Name - Kürzel" value="{{ $anforderung->an_label }}" />

                    <x-textfield id="updt_an_name" name="an_name" label="Name" value="{{ $anforderung->an_name }}" />

                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="updt_an_control_interval" name="an_control_interval" label="Prüfinterval" value="{{ $anforderung->an_control_interval }}" />
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="control_interval_id" label="Zeit">
                                @foreach (App\ControlInterval::all() as $controlInterval)
                                    <option value="{{ $controlInterval->id }}"
                                            @if ($controlInterval->id === $anforderung->control_interval_id)
                                                selected
                                            @endif
                                    >
                                        {{ $controlInterval->ci_label }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>

                    <x-textarea id="updt_an_description" name="an_description" label="Beschreibung" value="{{ $anforderung->an_description }}" />

                    <x-btnMain>Anforderung aktualisieren <i class="fas fa-download"></i></x-btnMain>

                </form>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Prüfungen zur Anforderung</h2>
                <table class="table table-responsive-md">
                    <thead>
                    <tr>
                        <th>Kürzel</th>
                        <th>Aufgabe</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\AnforderungControlItem::where('anforderung_id',$anforderung->id)->get() as $aci)
                        <tr>
                            <td>
                                <a href="{{ route('anforderungcontrolitem.show',$aci) }}">{{ $aci->aci_label }}</a>
                            </td>
                            <td>
                                {{ $aci->aci_name }}
                                @if ($aci->isIncomplete($aci))
                                    <ul class="text-warning">
                                        {!! $aci->isIncomplete($aci) !!}
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>Keine Prüfungen gefunden</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
