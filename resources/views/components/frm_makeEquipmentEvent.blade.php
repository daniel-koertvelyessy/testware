<form action="{{ route('equipmentevent.appstore') }}"
      method="post">
    @csrf
    <input type="hidden"
           name="equipment_id"
           id="equipment_id"
           value="{{ $edata->eq_uid }}"
    >
    @auth

        <input type="hidden"
               name="equipment_event_user"
               id="equipment_event_user"
               value="{{ Auth::user()->id }}"
        >

    @endauth
    <x-textarea id="equipment_event_text" label="Beschreibung"/>
    <button class="btn btn-primary">
        Schaden melden!
    </button>
</form>
