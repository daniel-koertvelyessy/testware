<div class="btn-group dropleft">
    <button type="button"
            class="btn  m-0 "
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
    >
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route($route.'.show',$object) }}"
           class="dropdown-item d-flex justify-content-between align-items-center"
        >
            {{__('Bearbeiten')}} <i class="fas fa-edit"></i>
        </a>
        <a href="#"
           class="dropdown-item d-flex justify-content-between align-items-center copyObject {{-- @if (!env('app.makeobjekte') ) disabled @endif --}} "
           data-objid="{{ $object->id }}"
           data-route="{{ $route }}"
        >Kopieren
            <i class="fas fa-copy"></i>
        </a>
        <a href=""
           onclick="event.preventDefault(); document.getElementById('frmDeleteObject{{ $object->id }}').submit();"
           class="dropdown-item d-flex justify-content-between align-items-center"
        >
            {{__('Löschen')}} <i class="fas fa-trash-alt"></i>
        </a>

    </div>
    <form action="{{ route($route.'.destroy',$object) }}"
          id="frmDeleteObject{{ $object->id }}"
          method="post"
    >
        @csrf
        @method('delete')


    </form>
</div>
