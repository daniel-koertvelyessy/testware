<div class="row">
    <div class="col-md-6">
        <x-textfield id="prod_name"
                     label="{{__('Bezeichnung')}}"
        />
    </div>
    <div class="col-md-6">
        <label for="produkt_kategorie_id">{{__('Kategorie')}}</label>
        <div class="input-group">
            <select name="produkt_kategorie_id"
                    id="produkt_kategorie_id"
                    class="custom-select"
            >
                @foreach (App\ProduktKategorie::all() as $produktKategorie)
                    <option value="{{ $produktKategorie->id }}"
                    @if (isset($pk))
                        {{ ($pk==$produktKategorie->id)? ' selected ': '' }}
                        @endif
                    >{{ $produktKategorie->pk_label }}</option>
                @endforeach
                @if (!isset($mkpk))
                    <option value="new">{{__('Neu anlegen')}}</option>
                @endif
            </select>
            @if (isset($mkpk))
                <button type="button"
                        class="btn btn-outline-primary ml-2"
                        data-toggle="modal"
                        data-target="#modalAddProduktKategorie"
                >
                    <i class="fas fa-plus"></i>
                </button>
            @else
                <label for="newProduktKategorie"
                       class="sr-only"
                >{{__('Neue Produktkategorie')}}</label>
                <input type="text"
                       id="newProduktKategorie"
                       name="newProduktKategorie"
                       class="form-control d-none"
                       placeholder="{{__('Neue Produktkategorie')}}"
                >
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <x-rtextfield id="prod_label"
                      label="{{__('Kurzbezeichnung / Spezifikation')}}"
                      max="20"
        />
    </div>
    <div class="col-md-4">
        <x-selectfield name="produkt_state_id"
                       id="produkt_state_id"
                       label="{{__('Status')}}"
        >
            @foreach (App\ProduktState::all() as $produktState)
                <option value="{{ $produktState->id }}">{{ $produktState->ps_label }}</option>
            @endforeach
        </x-selectfield>

    </div>
    <div class="col-md-2 d-flex align-self-center">
        <div class="form-check">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       class="custom-control-input"
                       id="prod_active"
                       name="prod_active"
                       checked
                       value="1"
                >
                <label class="custom-control-label"
                       for="prod_active"
                >{{__('Produkt aktiv')}}</label>
            </div>
        </div>
    </div>
    <div class="col-md-2 d-flex align-self-center">
        <div class="form-check">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       class="custom-control-input"
                       id="control_product"
                       name="control_product"
                       value="1"
                >
                <label class="custom-control-label"
                       for="control_product"
                >{{__('Ist Prüfmittel')}}</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <x-textfield id="prod_nummer"
                     class="checkLabel"
                     label="{{__('Artikelnummer')}}"
        />
        @if (isset($pk))
            @foreach (App\ProduktKategorieParam::where('produkt_kategorie_id',$pk)->get() as $pkpItem)

                <input type="hidden"
                       name="pp_label[]"
                       id="pp_label{{ $pkpItem->id }}"
                       value="{{ $pkpItem->pkp_label }}"
                >
                <input type="hidden"
                       name="pp_name[]"
                       id="pp_name_{{ $pkpItem->id }}"
                       value="{{ $pkpItem->pkp_name }}"
                >
                <x-textfield id="{{ $pkpItem->pkp_label }}"
                             label="{{ $pkpItem->pkp_name }}"
                />

            @endforeach
        @endif
        <x-textarea id="prod_description"
                    label="{{__('Beschreibung')}}"
        />
    </div>
</div>
