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
               id="context_item_open_{{ $object->id }}"
               class="dropdown-item context_item_open"
               data-target-id="{{ $object->id }}"
            >
                <i class="fas fa-folder-open mr-2 fa-fw"></i>
                {{__('Öffnen')}}
            </a>
        @endif
        @if($routeCopy!=='#')
            <a href="#"
               id="context_item_open_{{ $object->id }}"
               class="dropdown-item context_item_copy"
               data-target-id="{{ $object->id }}"
               onclick="event.preventDefault(); document.getElementById('frm_copy_object_{{ $object->id }}').submit();"
            >
                <i class="fas fa-copy mr-2 fa-fw"></i>
                {{__('Kopieren')}}
            </a>
        @endif
        @if($routeDestory!=='#')
            <a href="#"
               id="context_item_open_{{ $object->id }}"
               class="dropdown-item context_item_destroy"
               data-target-id="{{ $object->id }}"
               onclick="event.preventDefault(); document.getElementById('frm_delete_object_{{ $object->id }}').submit();"
            >
                <i class="far fa-trash-alt mr-2 fa-fw"></i>
                {{__('Löschen')}}
            </a>
        @endif
        @if($routeDestory!=='#')
            <form action="{{ $routeDestory }}#{{$tabName??''}}"
                  id="frm_delete_object_{{ $object->id }}"
                  method="post"
            >
                @csrf
                @method('DELETE')
                <input type="hidden"
                       name="id"
                       id="id_delete_object_{{ $object->id }}"
                       value="{{ $object->id }}"
                >
                <input type="hidden"
                       name="{{ $objectName }}"
                       id="{{ $objectName }}_delete_object_{{ $object->id }}"
                       value="{{ $objectVal }}"
                >
            </form>
        @endif
        @if($routeCopy!=='#')
            <form action="{{ $routeCopy }}#{{$tabName??''}}"
                  id="frm_copy_object_{{ $object->id }}"
                  method="post"
            >
                @csrf
                <input type="hidden"
                       name="id"
                       id="id_copy_object{{ $object->id }}"
                       value="{{ $object->id }}"
                >
                <input type="hidden"
                       name="frmOrigin"
                       id="frmOrigin_{{ $object->id }}"
                       value="{{ $objectName }}"
                >
                <input type="hidden"
                       name="{{ $objectName }}"
                       id="{{ $objectName }}_copy_object_{{ $object->id }}"
                       value="{{ $objectVal }}"
                >
            </form>
        @endif
    </div>
</div>

<script>

</script>
