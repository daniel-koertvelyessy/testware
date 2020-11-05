

<form action="{{ $action }}#{{ $tabtarget??'prodDoku' }}" method="post" id="delete{{ $prefix }}_{{ $id }}">
    @csrf
    @method('delete')
    <input type="hidden"
           name="id"
           id="delete_{{ $prefix }}_id_{{ $id }}"
           value="{{ $id }}"
    >

</form>
<button
    class="btn btn-sm btn-outline-secondary"
    onclick="event.preventDefault(); document.getElementById('delete{{ $prefix }}_{{ $id }}').submit();">
    <span class="far fa-trash-alt"></span>
</button>
