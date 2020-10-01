

<form action="{{ $action }}#prodDoku" method="post" id="deleteProdDoku_{{ $id }}">
    @csrf
    @method('delete')
    <input type="hidden"
           name="id"
           id="delete_produktdoc_id_{{ $id }}"
           value="{{ $id }}"
    >

</form>
<button
    class="btn btn-sm btn-outline-secondary"
    onclick="event.preventDefault(); document.getElementById('deleteProdDoku_{{ $id }}').submit();">
    <span class="far fa-trash-alt"></span>
</button>
