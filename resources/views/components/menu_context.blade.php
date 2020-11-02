<div class="btn-group dropleft">
    <button type="button"
            class="btn btn-sm m-0"
            id="editObjekt{{ $object->id }}"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
    >
        <i class="fas fa-bars"></i>
    </button>
    <div class="dropdown-menu"
         aria-labelledby="editObjekt{{ $object->id }}"
    >
        @if($routeOpen!=='#')
            <a href="{{ $routeOpen }}"
               class="dropdown-item d-flex justify-content-between align-items-center"
            >
                Öffnen <i class="fas fa-angle-right"></i>
            </a>
        @endif
        <a href="#"
           class="dropdown-item d-flex justify-content-between align-items-center {{--@if (!env('app.makeobjekte') ) disabled @endif--}}"
           onclick="event.preventDefault(); document.getElementById('frm_copy_object_{{ $object->id }}').submit();"
        >Kopieren <i class="fas fa-copy"></i>
        </a>
        <a href="#"
           class="dropdown-item d-flex justify-content-between align-items-center"
           onclick="event.preventDefault(); document.getElementById('frm_delete_object_{{ $object->id }}').submit();"
        >
            Löschen <i class="far fa-trash-alt"></i>
        </a>
        <form action="{{ $routeCopy }}#{{$tabName}}"
              id="frm_copy_object_{{ $object->id }}"
              method="post"
        >
            @csrf
            <input type="hidden"
                   name="id"
                   id="id_copy_object_{{ $object->id }}"
                   value="{{ $object->id }}"
            >
            <input type="hidden"
                   name="{{ $objectName }}"
                   id="{{ $objectName }}_copy_object_{{ $object->id }}"
                   value="{{ $objectVal }}"
            >
        </form>
        <form action="{{ $routeDestory }}#{{$tabName}}"
              id="frm_delete_object_{{ $object->id }}"
              method="post"
        >
            @csrf
            @method('delete')
            <input type="hidden"
                   name="id"
                   id="id_delete_object{{ $object->id }}"
                   value="{{ $object->id }}"
            >
            <input type="hidden"
                   name="frmOrigin"
                   id="frmOrigin_{{ $object->id }}"
                   value="locaion"
            >
            <input type="hidden"
                   name="{{ $objectName }}"
                   id="{{ $objectName }}_delete_object_{{ $object->id }}"
                   value="{{ $objectVal }}"
            >
        </form>

    </div>
</div>
