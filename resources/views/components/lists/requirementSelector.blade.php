
<label for="{{ $name . $id }}">{{ __('Anforderung') }}</label>
<select class="custom-select" id="{{ $name . $id }}" name="{{ $name }}">
    <option {{ $selected === NULL ? "selected" : "" }} value="0" >{{ __('bitte auswählen') }}</option>
    @foreach ($requirements as $requirement) {

    <option {{ $selected === $requirement->id ? "selected" : "" }} value="{{ $requirement->id }}">
        {{ $requirement->an_label }}
    </option>
    @endforeach
</select>
