@extends('layout.layout-admin')

@section('mainSection', __('Prüfungen'))

@section('pagetitle')
    {{ __('Übersicht Prüfungen') }}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h4">{{ __('Übersicht Prüfungen') }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-striped" id="tabControlListe">
                    <thead>
                        <tr>
                            <th>@sortablelink('Anforderung.an_name', __('Prüfung'))</th>
                            <th class="d-none d-md-table-cell">@sortablelink('Equipment.eq_name', __('Gerät'))</th>
                            <th>@sortablelink('Equipment.eq_inventar_nr', __('Inventarnummer'))</th>
                            <th>@sortablelink('qe_control_date_due', __('Fällig'))</th>
                            @if ($isSysAdmin)
                                <th>

                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($controlItems as $controlItem)
                            @php
                                $requirement = $controlItem->Anforderung;
                                $equipment = $controlItem->Equipment;
                                $isIncomplete = $requirement->isInComplete($requirement, $countControlProducts);
                            @endphp
                            @if (
                                $equipment &&
                                    $requirement  &&
                                    !$requirement ->is_initial_test &&
                                    !$controlItem->archived_at)

                                <tr>
                                    <td>
                                        <a href="{{ route('control.create', ['test_id' => $controlItem]) }}">
                                            <span class="d-md-none">
                                                {{ $requirement->an_label ?? 'n.a.' }}
                                            </span>
                                            <span class="d-none d-md-table-cell">
                                                @if ($isIncomplete)
                                                    <a href="{{ route('anforderung.show', $requirement) }}">
                                                        {{ $requirement->an_name }}
                                                    </a>
                                                    <span>
                                                        {!! $isIncomplete['msg'] !!}
                                                    </span>
                                                @else
                                                    {{ $requirement->an_name ?? 'na' }}
                                                @endif
                                            </span>
                                        </a>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        {{ $equipment->eq_name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('equipment.show', ['equipment' => $equipment]) }}">{{ $equipment->eq_inventar_nr }}
                                        </a>
                                    </td>
                                    <td>
                                        {!! $controlItem->checkDueDate($controlItem) !!}

                                        @if ($isIncomplete)
                                            <span class="d-md-none">
                                                {!! $isIncomplete['msg'] !!}
                                            </span>
                                        @endif
                                    </td>
                                    @if ($isSysAdmin)
                                        <td>

                                            <a role="button" class="small" data-toggle="modal"
                                                data-target="#editControlItemModal{{ $controlItem->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <div class="modal fade" id="editControlItemModal{{ $controlItem->id }}"
                                                tabindex="-1"
                                                aria-labelledby="editControlItemModalLabel{{ $controlItem->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <form action="{{ route('control.update', $controlItem) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editControlItemModalLabel{{ $controlItem->id }}">
                                                                    {{ __('Eintrag bearbeiten') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group col">
                                                                        <label
                                                                            for="qe_control_eq_name_{{ $controlItem->id }}">{{ __('Zu prüfendes Gerät') }}</label>
                                                                        <input type="text" readonly
                                                                            class="form-control-plaintext"
                                                                            id="qe_control_eq_name_{{ $controlItem->id }}"
                                                                            name="qe_control_eq_name"
                                                                            value="{{ $equipment->eq_name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col">
                                                                        <x-lists.requirementSelector
                                                                                :requirements="$requirements"
                                                                                :id="$controlItem->id"
                                                                                :selected="$controlItem->anforderung_id"
                                                                                name="anforderung_id"
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label
                                                                            for="qe_control_date_last_{{ $controlItem->id }}">{{ __('Letzte Prüfung') }}</label>
                                                                        <input type="text"
                                                                            class="form-control datepicker"
                                                                            id="qe_control_date_last_{{ $controlItem->id }}"
                                                                            name="qe_control_date_last"
                                                                            value="{{ $controlItem->qe_control_date_last }}">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label
                                                                            for="qe_control_date_due_{{ $controlItem->id }}">{{ __('Prüfung fällig') }}</label>
                                                                        <input type="text"
                                                                            class="form-control datepicker"
                                                                            id="qe_control_date_due_{{ $controlItem->id }}"
                                                                            name="qe_control_date_due"
                                                                            value="{{ $controlItem->qe_control_date_due }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label
                                                                            for="qe_control_date_warn_{{ $controlItem->id }}">{{ __('Vorlauf') }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="qe_control_date_warn_{{ $controlItem->id }}"
                                                                            name="qe_control_date_warn"
                                                                            value="{{ $controlItem->qe_control_date_warn }}">
                                                                    </div>
                                                                    <div class="form-group col-md-8">
                                                                        <x-lists.intervalTypeSelector
                                                                                :selected="$controlItem->id"
                                                                                name="wedwqe"
                                                                                :id="$controlItem->id"
                                                                                :intervalTypeList="$controlIntervalList"
                                                                        />
                                                                    </div>

                                                                </div>
                                                                <input type="hidden" name="equipment_id"
                                                                    id="equipment_id_{{ $controlItem->id }}"
                                                                    value="{{ $controlItem->equipment_id }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">{{ __('Abbruch') }}
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Aktualisieren') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a role="button" class="small text-danger mx-1" data-toggle="modal"
                                                data-target="#deleteControlItemModal{{ $controlItem->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            <div class="modal fade" id="deleteControlItemModal{{ $controlItem->id }}"
                                                tabindex="-1"
                                                aria-labelledby="deleteControlItemModalLabel{{ $controlItem->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white"
                                                                id="deleteControlItemModalLabel{{ $controlItem->id }}">
                                                                {{ __('Eintrag löschen') }}</h5>
                                                            <button type="button" class="close text-white"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <p class="lead">Die Prüfung wird aus der Datenbank
                                                                        entfernt und kann
                                                                        nicht wierder hergestellt werden. Als Alternative
                                                                        kann die Prüfung auch archiviert werden. Sie tauch
                                                                        damit nicht mehr in den aktiven Listen auf.</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col d-flex justify-content-between">
                                                                    <form
                                                                        action="{{ route('control.archive', $controlItem) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button class="btn btn-outline-secondary">Prüfung
                                                                            archivieren
                                                                        </button>
                                                                    </form>

                                                                    <form
                                                                        action="{{ route('control.destroy', $controlItem) }}"
                                                                        id="deleteEquipmentControlItem{{ $controlItem->id }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="id"
                                                                            id="deleteEquipmentControlId{{ $controlItem->id }}"
                                                                            value="{{ $controlItem->id }}">
                                                                        <button class="btn btn-outline-danger">Endgültig
                                                                            löschen
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    @endif
                                </tr>
                            @endif
                            @if ($requirement && $requirement->isInComplete($requirement, $countControlProducts))
                                <tr>
                                    <td colspan="5">
                                        <blockquote class="d-md-none blockquote border-left border-warning pl-3">
                                            <span class="fas fa-exclamation-triangle text-warning"
                                                aria-label="Symbol für unvollständige Prüfung"></span>
                                            {{ __('Prüfung ist unvollständig. Vor dem Start der Prüfung muss diese ergänzt werden.') }}
                                        </blockquote>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5">
                                    <x-notifyer>{{ __('Es sind bislang keine Prüfungen angelegt') }}</x-notifyer>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($controlItems->count() > 1)
                    <div class="d-flex justify-content-center">
                        {!! $controlItems->withQueryString()->onEachSide(2)->links() ?? '' !!}
                    </div>
                @endif

                @if ($isSysAdmin && $archivedControlItems->count() > 0)
                    <hr class="my-4">
                    <h2 class="h4">{{ __('Archivierte Prüfungen') }}</h2>
                    <table class="table table-striped" id="tabControlListe">
                        <thead>
                            <tr>
                                <th>@sortablelink('Anforderung.an_name', __('Prüfung'))</th>
                                <th class="d-none d-md-table-cell">@sortablelink('Equipment.eq_name', __('Gerät'))</th>
                                <th>@sortablelink('Equipment.eq_inventar_nr', __('Inventarnummer'))</th>
                                <th>@sortablelink('qe_control_date_due', __('Fällig'))</th>
                                @if ($isSysAdmin)
                                    <th>

                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($archivedControlItems as $controlItem)

@php

$requirement = $controlItem->Anforderung;
$equipment = $controlItem->Equipment;
$isIncomplete = $requirement->isInComplete($requirement, $countControlProducts);
 @endphp

                                @if ($controlItem->archived_at !== null)
                                    <tr>
                                        <td>
                                            <a href="{{ route('control.create', ['test_id' => $controlItem]) }}">
                                                <span class="d-md-none">
                                                    {{ $requirement->an_label ?? 'n.a.' }}
                                                </span>
                                                <span class="d-none d-md-table-cell">
                                                    @if ($isIncomplete)
                                                        <a
                                                            href="{{ route('anforderung.show', $requirement) }}">
                                                            {{ $requirement->an_name }}
                                                        </a>
                                                        <span>
                                                            {!! $isIncomplete['msg'] !!}
                                                        </span>
                                                    @else
                                                        {{ $requirement->an_name ?? 'na' }}
                                                    @endif
                                                </span>
                                            </a>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $equipment ->eq_name }}
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('equipment.show', ['equipment' => $equipment ]) }}">{{ $equipment ->eq_inventar_nr }}
                                            </a>
                                        </td>
                                        <td>
                                            {!! $controlItem->checkDueDate($controlItem) !!}
                                            @if ($isIncomplete)
                                                <span class="d-md-none">
                                                    {!! $isIncomplete['msg'] !!}
                                                </span>
                                            @endif
                                        </td>
                                        <td>

                                            <a role="button" class="small" data-toggle="modal"
                                                data-target="#editControlItemModal{{ $controlItem->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <div class="modal fade" id="editControlItemModal{{ $controlItem->id }}"
                                                tabindex="-1"
                                                aria-labelledby="editControlItemModalLabel{{ $controlItem->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <form action="{{ route('control.update', $controlItem) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editControlItemModalLabel{{ $controlItem->id }}">
                                                                    {{ __('Eintrag bearbeiten') }}</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group col">
                                                                        <label
                                                                            for="qe_control_eq_name_{{ $controlItem->id }}">{{ __('Zu prüfendes Gerät') }}</label>
                                                                        <input type="text" readonly
                                                                            class="form-control-plaintext"
                                                                            id="qe_control_eq_name_{{ $controlItem->id }}"
                                                                            name="qe_control_eq_name"
                                                                            value="{{ $controlItem->Equipment->eq_name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col">
                                                                        <x-lists.requirementSelector
                                                                                :requirements="$requirements"
                                                                                :id="$controlItem->id"
                                                                                :selected="$controlItem->id"
                                                                                name="anforderung_id"
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label
                                                                            for="qe_control_date_last_{{ $controlItem->id }}">{{ __('Letzte Prüfung') }}</label>
                                                                        <input type="text"
                                                                            class="form-control datepicker"
                                                                            id="qe_control_date_last_{{ $controlItem->id }}"
                                                                            name="qe_control_date_last"
                                                                            value="{{ $controlItem->qe_control_date_last }}">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label
                                                                            for="qe_control_date_due_{{ $controlItem->id }}">{{ __('Prüfung fällig') }}</label>
                                                                        <input type="text"
                                                                            class="form-control datepicker"
                                                                            id="qe_control_date_due_{{ $controlItem->id }}"
                                                                            name="qe_control_date_due"
                                                                            value="{{ $controlItem->qe_control_date_due }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label
                                                                            for="qe_control_date_warn_{{ $controlItem->id }}">{{ __('Vorlauf') }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="qe_control_date_warn_{{ $controlItem->id }}"
                                                                            name="qe_control_date_warn"
                                                                            value="{{ $controlItem->qe_control_date_warn }}">
                                                                    </div>
                                                                    <div class="form-group col-md-8">
                                                                        <x-lists.intervalTypeSelector
                                                                                :selected="$controlItem->id"
                                                                                name="wedwqe"
                                                                                :id="$controlItem->id"
                                                                                :intervalTypeList="$controlIntervalList"
                                                                        />
                                                                    </div>

                                                                </div>
                                                                <input type="hidden" name="equipment_id"
                                                                    id="equipment_id_{{ $controlItem->id }}"
                                                                    value="{{ $controlItem->equipment_id }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">{{ __('Abbruch') }}
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Aktualisieren') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a role="button" class="small text-success mx-1" data-toggle="modal"
                                                data-target="#reactivateControlItem{{ $controlItem->id }}">
                                                <i class="fas fa-redo"></i>
                                            </a>

                                            <div class="modal fade" id="reactivateControlItem{{ $controlItem->id }}"
                                                tabindex="-1"
                                                aria-labelledby="reactivateControlItemLabel{{ $controlItem->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="reactivateControlItemLabel{{ $controlItem->id }}">
                                                                {{ __('Eintrag wiederherstellen') }}</h5>
                                                            <button type="button" class="close text-white"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="col d-flex justify-content-between">
                                                                    <form
                                                                        action="{{ route('control.reactivate', $controlItem) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button class="btn btn-outline-secondary">Prüfung
                                                                            wiederherstellen
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

@endsection
{{-- @section('scripts')
    @if ($controlItems->count() > 0)
        <link rel="stylesheet"
              type="text/css"
              href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"
        >
        <script type="text/javascript"
                charset="utf8"
                src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"
        ></script>

        <script>

            $('#tabControlListe').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                "columnDefs": [
                    {"orderable": false, "targets": 4}
                ],
                "dom": '<"top"i>rt<"bottom"p><"clear">',
                "pagingType": "full"
            });
        </script>
    @endif
@endsection --}}
