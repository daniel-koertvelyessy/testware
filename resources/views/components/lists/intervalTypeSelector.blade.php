@props([
    'name' => $name ?? 'control_interval_id_'.\Illuminate\Support\Str::random(3),
    'id' => $id ?? 0,
    'selected' => 0,
    'intervalTypeList' => []
])
<section>
    <label for="control_interval_id_{{ $id }}">{{ __('Intervall') }}</label>
    <select class="custom-select"
            id="control_interval_id_{{ $id }}"
            name="{{ $name }}"
    >
        <option {{ $selected === null ? "selected" : "" }} value="0">{{ __('bitte auswählen') }}</option>
        @foreach ($intervalTypeList as $intervalType)
            {
            <option {{ $selected === $intervalType->id ? "selected" : "" }} value="{{ $intervalType->id }}">
                {{ $intervalType->ci_label }}
            </option>
        @endforeach
    </select>
</section>