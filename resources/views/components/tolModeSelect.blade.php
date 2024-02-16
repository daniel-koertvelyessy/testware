<label for="{{ $id }}">{{__('Zielwert i.O.')}}</label>
<select name="{{ $id }}"
        id="{{ $id }}"
        class="custom-select"
>
    @if(isset($setdp))
    <option @if($mode === NULL) selected @endif
    value=""
    >{{ __('Prüfschritt ohne Zielwert') }}</option>
    @endif
    <option @if($mode ==='lt') selected
            @endif value="lt"
    >{{__('Kleiner als Soll')}}
    </option>
    <option @if($mode ==='eq') selected
            @endif value="eq"
    >{{__('Gleich ± Toleranz')}}
    </option>
    <option @if($mode ==='gt') selected
            @endif value="gt"
    >{{__('Größer als Soll')}}
    </option>
    @if(isset($setdp))
    <option @if($mode ==='dp') selected
            @endif value="dp"
    >{{__('Datenpunkte')}}
    </option>
    @endif
</select>