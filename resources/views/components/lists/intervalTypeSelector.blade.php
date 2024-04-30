
<label for="control_interval_id_{{ $id }}">{{ __('Intervall') }}</label>
<select class="custom-select" id="{{ $name . $id }}" name="{{ $name }}">
    <option {{ $selected === NULL ? "selected" : "" }} value="0" >{{ __('bitte auswählen') }}</option>
    @foreach ($intervalTypeList as $intervalType) {
    <option {{ $selected === $intervalType->id ? "selected" : "" }} value="{{ $intervalType->id }}">
        {{ $intervalType->ci_label }}
    </option>
    @endforeach
</select>
