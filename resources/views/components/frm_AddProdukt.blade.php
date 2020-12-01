<div class="row">
    <div class="col-md-6">
        <x-textfield id="prod_name_lang"
                     label="Bezeichnung"
        />
    </div>
    <div class="col-md-6">
        <label for="produkt_kategorie_id">Produkt Kategorie</label>
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
                    >{{ $produktKategorie->pk_name_kurz }}</option>
                @endforeach
                @if (!isset($mkpk))
                    <option value="new">Neu anlegen</option>
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
                >Neue Produktkategorie</label>
                <input type="text"
                       id="newProduktKategorie"
                       name="newProduktKategorie"
                       class="form-control d-none"
                       placeholder="Neue Produktkategorie"
                >
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <x-rtextfield id="prod_name_kurz"
                      label="Kurzbezeichnung / Spezifikation"
                      max="20"
        />
    </div>
    <div class="col-md-4">
        <x-selectfield name="produkt_state_id"
                       id="produkt_state_id"
                       label="Produkt Status"
        >
            @foreach (App\ProduktState::all() as $produktState)
                <option value="{{ $produktState->id }}">{{ $produktState->ps_name_kurz }}</option>
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
                >Produkt aktiv</label>
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
                     label="Artikel Nummer"
        />
        @if (isset($pk))
            @foreach (App\ProduktKategorieParam::where('produkt_kategorie_id',$pk)->get() as $pkpItem)
                <div class="form-group">
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

                    <label for="{{ $pkpItem->pkp_label }}">{{ $pkpItem->pkp_name }}</label>
                    <input type="text"
                           class="form-control"
                           maxlength="150"
                           name="pp_value[]"
                           id="{{ $pkpItem->pkp_label }}"
                           value="{{ old($pkpItem->pkp_label)??'' }}"
                    >
                    @if ($errors->has($pkpItem->pkp_label))
                        <span class="text-danger small">{{ $errors->first($pkpItem->pkp_label) }}</span>
                    @else
                        <span class="small text-primary">max 100 Zeichen</span>
                    @endif
                </div>
            @endforeach
        @endif
        <div class="form-group">
            <label for="prod_name_text">Beschreibung</label>
            <textarea name="prod_name_text"
                      id="prod_name_text"
                      class="form-control"
                      rows="3"
            >{{ old('prod_name_text') }}</textarea>
        </div>
    </div>
</div>
