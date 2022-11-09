@extends('layout.layout-app')

@section('content')

    <form action="{{ route('control.edit',$controlItem) }}"
          method="POST"
    >
        @csrf

        <div class="modal-header">
            <h5 class="modal-title"
                id="editControlItemModalLabel{{$controlItem->id}}"
            >{{ __('Eintrag bearbeiten') }}</h5>
            <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col">
                    <label for="qe_control_eq_name_{{$controlItem->id}}">{{ __('Zu prüfendes Gerät') }}</label>
                    <input type="text"
                           readonly
                           class="form-control-plaintext"
                           id="qe_control_eq_name_{{$controlItem->id}}"
                           name="qe_control_eq_name"
                           value="{{ $controlItem->Equipment->eq_name }}"
                    >
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label for="anforderung_id_{{$controlItem->id}}">{{ __('Anforderung') }}</label>
                    {!! (new \App\Http\Services\Control\ControlEquipmentService)->setRequirementSelector(
'anforderung_id',
$controlItem->id,
$controlItem->anforderung_id
) !!}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="qe_control_date_last_{{$controlItem->id}}">{{ __('Letzte Prüfung') }}</label>
                    <input type="text"
                           class="form-control datepicker"
                           id="qe_control_date_last_{{$controlItem->id}}"
                           name="qe_control_date_last"
                           value="{{ $controlItem->qe_control_date_last }}"
                    >
                </div>
                <div class="form-group col-md-6">
                    <label for="qe_control_date_due_{{$controlItem->id}}">{{ __('Prüfung fällig') }}</label>
                    <input type="text"
                           class="form-control datepicker"
                           id="qe_control_date_due_{{$controlItem->id}}"
                           name="qe_control_date_due"
                           value="{{ $controlItem->qe_control_date_due }}"
                    >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="qe_control_date_warn_{{$controlItem->id}}">{{ __('Vorlauf') }}</label>
                    <input type="text"
                           class="form-control"
                           id="qe_control_date_warn_{{$controlItem->id}}"
                           name="qe_control_date_warn"
                           value="{{ $controlItem->qe_control_date_warn }}"
                    >
                </div>
                <div class="form-group col-md-8">
                    <label for="qe_control_date_warn_{{$controlItem->id}}">{{ __('Intervall') }}</label>
                    {!! (new \App\Http\Services\Control\ControlEquipmentService)->setIntervalTypeSelector(
'control_interval_id',
$controlItem->id,
$controlItem->control_interval_id
) !!}
                </div>

            </div>
            <input type="hidden"
                   name="equipment_id"
                   id="equipment_id_{{ $controlItem->id }}"
                   value="{{ $controlItem->equipment_id }}"
            >
        </div>
        <div class="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
            >{{ __('Abbruch') }}
            </button>
            <button type="submit"
                    class="btn btn-primary"
            >{{ __('Aktualisieren') }}
            </button>
        </div>
    </form>

@endsection